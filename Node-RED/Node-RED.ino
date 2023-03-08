#include <DHT.h>
#include <LiquidCrystal_I2C.h>  //Library For
#define DHT11PIN D7
#define DHTTYPE DHT11

DHT dht(DHT11PIN, DHTTYPE, 15);
LiquidCrystal_I2C lcd(0x27, 20, 2);  // CHANGE THE 0X27 ADDRESS TO YOUR SCREEN ADDRESS IF NEEDED

float Humidity = 0;
float Temprature = 0;

void setup() {
  Serial.begin(9600);
  Serial.println(F("DHT11 Unified Sensor Example"));
  Serial.begin(9600);
  dht.begin();
  lcd.begin(16, 2);
  lcd.init();
  lcd.backlight();
}

void loop() {
  Temprature = dht.readTemperature();
  Humidity = dht.readHumidity();

  lcd.clear();
  lcd.print("TEMP  : ");
  lcd.print(Temprature);
  lcd.print((char)223);
  lcd.print("C");
  lcd.setCursor(0, 1);
  lcd.print("HUMID : ");
  lcd.print(Humidity);
  lcd.print("%");
  Serial.print("{\"Hum\":");
  Serial.print(Humidity);
  Serial.print(",\"Temp\":");
  Serial.print(Temprature);
  Serial.println("}");
  delay(300000);
}