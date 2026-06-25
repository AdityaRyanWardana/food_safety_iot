#include <WiFi.h>
#include <HTTPClient.h>
#include <DHT.h>

// ======================
// KONFIGURASI WIFI & API
// ======================
const char* ssid = "NAMA_WIFI_ANDA";         // Ganti dengan nama WiFi Anda
const char* password = "PASSWORD_WIFI_ANDA"; // Ganti dengan password WiFi Anda

// Ganti IP_LAPTOP dengan IP Address dari laptop/komputer yang menjalankan Laravel (contoh: 192.168.1.10)
// Penting: Laptop dan ESP32 harus terhubung di jaringan WiFi yang sama!
const char* serverName = "http://IP_LAPTOP:8000/api/sensor-data";

// ======================
// DHT22
// ======================
#define DHTPIN 4
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

// ======================
// MQ135 & LED
// ======================
#define MQ135_PIN 35
#define LED_HIJAU   18
#define LED_KUNING  21
#define LED_MERAH   22

void setup() {
  Serial.begin(115200);

  // 1. Inisialisasi Koneksi WiFi
  Serial.println();
  Serial.print("Menghubungkan ke WiFi: ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi Terhubung!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  // 2. Inisialisasi Sensor & LED
  dht.begin();
  analogReadResolution(12);
  analogSetAttenuation(ADC_11db);

  pinMode(LED_HIJAU, OUTPUT);
  pinMode(LED_KUNING, OUTPUT);
  pinMode(LED_MERAH, OUTPUT);

  Serial.println("Sistem Monitoring Siap!");
}

void loop() {
  // 1. Baca Data Sensor
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();
  int adc = analogRead(MQ135_PIN);
  float voltage = adc * (3.3 / 4095.0);

  // Jika sensor DHT gagal membaca, lewati loop ini
  if (isnan(temperature) || isnan(humidity)) {
    Serial.println("Gagal membaca dari sensor DHT!");
    delay(2000);
    return;
  }

  // Matikan semua LED
  digitalWrite(LED_HIJAU, LOW);
  digitalWrite(LED_KUNING, LOW);
  digitalWrite(LED_MERAH, LOW);

  // 2. Klasifikasi Status (Sesuai dengan SensorTestController.php)
  String quality;
  if (adc < 1200) {
    quality = "AMAN";
    digitalWrite(LED_HIJAU, HIGH);
  } else if (adc < 1400) {
    quality = "TERKONTAMINASI";
    digitalWrite(LED_KUNING, HIGH);
  } else {
    quality = "BAHAYA";
    digitalWrite(LED_MERAH, HIGH);
  }

  // 3. Output ke Serial Monitor
  Serial.println("\n================================");
  Serial.printf("Suhu      : %.1f °C\n", temperature);
  Serial.printf("Lembab    : %.1f %%\n", humidity);
  Serial.printf("Gas (ADC) : %d\n", adc);
  Serial.printf("Status    : %s\n", quality.c_str());

  // 4. Kirim Data ke Laravel (jika WiFi terhubung)
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverName);
    http.addHeader("Content-Type", "application/json");

    // Membuat JSON Payload secara manual (bisa juga pakai library ArduinoJson)
    // Field yang dikirim disesuaikan dengan validasi di SensorTestController
    String jsonPayload = "{";
    jsonPayload += "\"temperature\": " + String(temperature) + ",";
    jsonPayload += "\"humidity\": " + String(humidity) + ",";
    jsonPayload += "\"gas_level\": " + String(adc) + ",";
    jsonPayload += "\"sample_name\": \"Sensor ESP32\""; // Opsional: Beri nama sampel
    jsonPayload += "}";

    Serial.println("Mengirim data ke Server...");
    int httpResponseCode = http.POST(jsonPayload);

    if (httpResponseCode > 0) {
      Serial.printf("HTTP Response code: %d\n", httpResponseCode);
      String response = http.getString();
      Serial.println("Server Reply: " + response);
    } else {
      Serial.printf("Error code: %d\n", httpResponseCode);
    }
    http.end();
  } else {
    Serial.println("WiFi Disconnected. Data tidak terkirim.");
  }

  // Jeda 10 detik sebelum pengiriman berikutnya
  delay(10000);
}
