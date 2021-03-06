#!/usr/bin/env python
# vim: ts=4 sw=4 et

import requests

# Obtain token -> https://push-pole.com/docs/api/#api_get_token
TOKEN = 'YOUR_TOKEN'

# set header
headers = {
    'Authorization': 'Token ' + TOKEN,
    'Content-Type': 'application/json'
}

# Android -> https://push-pole.com/docs/api/

data = {
    'app_ids': ['YOUR_APP_ID', ],
    'data': {
        'title': 'this is the title',
        'content': 'this is the content',
    },
    'filters': {
        'device_id': ['DEIVCE_ID_1', 'DEVICE_ID_2']
    },
}

response = requests.post(
    'https://api.push-pole.com/v2/messaging/notifications/',
    json=data,
    headers=headers,
)

print('status code => ', response.status_code)
print('response => ', response.json())
print('==========')

if response.status_code == 201:
    print('Success!')

    data = response.json()

    # hashed_id just generated for Non-Free plan
    if data['hashed_id']:
        report_url = 'https://push-pole.com/report?id=%s' % data['hashed_id']
    else:
        report_url = 'no report url for your plan'

    notif_id = data['wrapper_id']
    print('report_url: %s' % report_url)
    print('notification id: %s' % notif_id)
else:
    print('failed')
