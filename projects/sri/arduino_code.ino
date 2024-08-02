//Smart Road Infrastructure Monitoring and Maintenance System
// Author: Juan Pendás Arévalo
// Hacksterio IoT The Future of Resilience Contest

//Libraries
#include <Arduino.h>
#include <mcp9808.h>
#include <mqtt_client.h>
#include <lte.h>

//Definitions
#define MQTT_THING_NAME "ITC"
#define IO_USERNAME "Tels30" 
#define IO_KEY " "
#define MQTT_USE_TLS false
#define MQTT_KEEPALIVE 60
#define MQTT_USE_ECC false
#define AIO_SERVER "io.adafruit.com"
#define AIO_SERVERPORT 1883
#define MQTT_PUB_TOPIC1 "Tels30/feeds/Log"
#define MQTT_PUB_TOPIC2 "Tels30/feeds/Temp"
#define MQTT_PUB_TOPIC3 "Tels30/feeds/Cars"

//Variables
bool carIn = false;
unsigned long entryTime = 0, elapsedTime = 0;
int carsPerHour = 0, speed;
int T = 60, last_time;

//Funtion to send data to Adafruit
void publishAda(String string, int i) {

  // Attempt to connect to the broker
  if (MqttClient.begin(MQTT_THING_NAME,
                       AIO_SERVER,
                       AIO_SERVERPORT,
                       MQTT_USE_TLS,
                       MQTT_KEEPALIVE,
                       MQTT_USE_ECC,
                       IO_USERNAME,
                       IO_KEY)) {

    Serial3.println("MQTT connection established");

    bool publishedSuccessfully;

    //Switch to choose beteewn the different topics of Adafruit server
    switch (i) {
      case 0:
        publishedSuccessfully = MqttClient.publish(MQTT_PUB_TOPIC1, string.c_str());
        break;
      case 1:
        publishedSuccessfully = MqttClient.publish(MQTT_PUB_TOPIC2, string.c_str());
        break;
      case 2:
        publishedSuccessfully = MqttClient.publish(MQTT_PUB_TOPIC3, string.c_str());
        break;
      default:
        Serial3.print("Error");
    }


    //Confirmation of publish
    if (publishedSuccessfully) {
      Serial3.print("Published message: ");
      Serial3.println(string);
    } else {
      Serial3.println("Failed to publish");
    }
    Serial3.println("Closing MQTT connection");
    delay(200);

  } else {
    Serial3.println("Connection to MQTT failed");
  }
  MqttClient.end();
}


void setup() {
  //Initialize the Serial mMnitor
  Serial3.begin(115200);

  if (Mcp9808.begin(0x18)) {
    Serial3.println("Error");
  }

  Serial3.println("AVRIoT Cellular mini on");

  // Establish LTE connection
  if (!Lte.begin()) {
    Serial3.println("Failed to connect to operator");

    // Halt here
    while (1) {}
  }
  Serial3.println("Connected to operator");

  last_time = millis();
}

void loop() {

  if (millis() - last_time > 60000) {
    last_time = millis();
    T--;
  }

  //The temperature and the number of cars per hour should be sended every hour, but at the time to try the code we use T = 30 seconds
  if (T < 1) {

    int Temp = (int)Mcp9808.readTempC() - 163;  //Save the temperature value in Temp
    Serial3.print("Temperatura: ");
    Serial3.println(Temp);  //Print the temperature in the serial monitor
    publishAda("Temperatura: " + (String)Temp, 0);
    publishAda((String)Temp, 1);

    publish((String)carsPerHour, 2);
    carsPerHour = 0;

    delay(200);
    T = 60;
  }

  int sensorValue = analogRead(PIN_PA0);

  if (sensorValue < 1000 && carIn == false) {
    carIn = true;
    entryTime = millis();
    Serial3.println("Car in");

  } else if (sensorValue > 1000 && carIn) {
    carIn = false;
    elapsedTime = millis() - entryTime;

    /*Obtain the speed with the elapsedTime and with a cosntant value 
      this gives us an aproximity of the speed but the real speed will 
      depends on the lenght of the car*/
    speed = 20000 / elapsedTime;

    //Discard values fester that 200 mph
    if (speed < 200) {
      carsPerHour++;
      Serial3.println("Car out: Time: " + (String)elapsedTime + "ms" + " Speed: " + (String)speed + "mph");
      publishAda("Car detected: Time: " + (String)elapsedTime + "ms" + " Speed: " + (String)speed + "mph", 0);
    } else {
      Serial3.println("Measurement error");
    }

  } else {
    delay(50);
  }
}