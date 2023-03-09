#include <DHT.h>
#include <ESP8266WiFi.h>
#include <LiquidCrystal_I2C.h>
#include "TRIGGER_WIFI.h"               
#include "TRIGGER_GOOGLESHEETS.h"  

#define DHT11PIN D7
#define DHTTYPE DHT11
#define LED_pin1 D5
#define LED_pin2 D8

char column_name_in_sheets[ ][20] = {"value1","value2"};                        /*1. The Total no of column depends on how many value you have created in Script of Sheets;2. It has to be in order as per the rows decided in google sheets*/
String Sheets_GAS_ID = "AKfycbwrllNXDVMYWmvTfuXjh16ivcNJ-xLVkT0JMvZZ3BSvcmoWwFWRkw6_GLQ9Te0Mp78Q4A";                                         /*This is the Sheets GAS ID, you need to look for your sheets id*/
int No_of_Parameters = 2;      

DHT dht(DHT11PIN, DHTTYPE, 15);
LiquidCrystal_I2C lcd(0x27, 20, 2); // CHANGE THE 0X27 ADDRESS TO YOUR SCREEN ADDRESS IF NEEDED

String apiKey = "KFZ34WQXEQN8BMYL";
const char* ssid = "SysAdmin";
const char* password = "Sys@dm1n123";

void setup() {
  //Setup LED, Serial, DHT, LCD
  pinMode(LED_pin1, OUTPUT);
  pinMode(LED_pin2, OUTPUT);
  Serial.begin(9600);
  dht.begin();
  lcd.begin(16,2);
  lcd.init();
  lcd.noBacklight();

  //Loop WiFi Connection
  WiFi.begin(ssid, password);
  while(WiFi.status() != WL_CONNECTED){
    digitalWrite(LED_pin1, HIGH);
    Serial.print("WiFi Not Connected");
    delay(500);
    digitalWrite(LED_pin1, LOW);
  }
  WIFI_Connect(ssid, password);
  Google_Sheets_Init(column_name_in_sheets, Sheets_GAS_ID, No_of_Parameters );
  //LCD, Lampu D6 Hidup Jika Koneksi Wifi Berhasil
  lcd.backlight();
  digitalWrite(LED_pin2, HIGH);
}

void loop() {
  //Read Temperature and Humidity
  float suhu = dht.readTemperature();
  float lembab = dht.readHumidity();
  lcd.clear();
  lcd.print("TEMP  : ");
  lcd.print(suhu);
  lcd.print((char)223);
  lcd.print("C");
  lcd.setCursor(0,1);
  lcd.print("HUMID : ");
  lcd.print(lembab);
  lcd.print("%");
  Serial.print("Temperature ");
  Serial.print(suhu);
  Serial.print("°C");
  Serial.print(" Humidity ");
  Serial.print(lembab);
  Serial.println("%");
  Data_to_Sheets(No_of_Parameters,  suhu,  lembab);
  delay(2000);
}
