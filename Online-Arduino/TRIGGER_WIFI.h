#ifndef __TRIGGER_WIFI_H__
#define __TRIGGER_WIFI_H__

#include <ESP8266WiFi.h>
#include <WiFiClientSecure.h>

//const char* ssid = "X-men trainee";    // name of your wifi network!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//const char* password = "Qwertyuiop69";     // wifi pasword !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

WiFiClientSecure client;

#define Debug_Serial_Mon

void WIFI_Connect(const char* wifi_id, const char *wifi_password)
{
  #ifdef Debug_Serial_Mon
  #endif
  
  WiFi.mode(WIFI_STA);
  WiFi.begin(wifi_id, wifi_password);
  
  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
  }
  #ifdef Debug_Serial_Mon
  #endif
}
#endif
