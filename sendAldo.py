#!/usr/bin/env python
import pika

credentials = pika.PlainCredentials('super','password')
#parameters = pika.ConnectionParameters( 5672, '192.168.1.25' , credentials)
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.26', '5672', '/', credentials))
channel = connection.channel()

channel.queue_declare(queue='hello')

channel.basic_publish(exchange='',
                      routing_key='hello',
                      body='Hello World!')
print(" [x] Sent 'Hello World!'")

connection.close()
