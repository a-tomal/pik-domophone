### Домофон.ПИК неофициальный клиент

Проект был разработан в целях тестирования работоспособности intercom.pik-comfort.ru/api.

В текущей реализации проект умеет
* Проходить авторизацию
* Получать актуальные URI RTSP потоков (они обновляются)
* Открывать определенные домофоны

### Интеграция в Home Assistant

Поскольку URI RTSP потоков динамические, необходимо создать сенсор, который будет получать актуальные ссылки

```yaml
sensor:
  - platform: rest
    resource: %BASE_URL%/stream/list
    method: GET
    name: yard_stream
    scan_interval: 60
    value_template: '{{ value_json[0] }}'
```

После этого, создаем камеру
```yaml
camera:
  - platform: generic
    name: YARD
    still_image_url: ""
    stream_source: '{{ states("sensor.yard_stream") }}'
```

В качестве плеера, я использую [AlexxIT/WebRTC](https://github.com/AlexxIT/WebRTC).

```yaml
type: horizontal-stack
title: Камеры
cards:
  - type: 'custom:webrtc-camera'
    entity: camera.street
    intersection: 0.75
    ui: true
    background: true
    webrtc: true
  - type: 'custom:webrtc-camera'
    entity: camera.yard
    intersection: 0.75
    ui: true
    background: true
    webrtc: tru
  - type: 'custom:webrtc-camera'
    entity: camera.hall
    intersection: 0.75
    ui: true
    background: true
    webrtc: true
```

![Скришот](https://i.imgur.com/AkOeeeh.png)

Make feel to contribute!
