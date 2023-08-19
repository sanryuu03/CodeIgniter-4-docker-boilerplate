This is a [CodeIgniter 4 v4.3.7](https://codeigniter.com) with [NGINX](https://www.nginx.com).

## Penggunaan

- build

      docker compose build

- create

      docker compose create

- start

      docker compose start

- one line => Builds, (re)creates, starts, and attaches to containers for a service.

      docker compose up
      docker compose up -d => --detach , -d		Detached mode: Run containers in the background

- cek image

      docker image ls
      atau menggunakan group
      docker image ls | grep nama => docker image ls | grep ci4

- cek container

      docker container ls -a
      atau
      docker compose ps

- stop

      docker compose down

- hapus image

      docker image rm IMAGE ID

- masuk ke dalam container

      docker exec -i -t nginx-ci4 /bin/bash

- list file

      ls -al

- masuk ke ci4

      http://localhost

## Informasi

- Boilerplate CodeIgniter 4 ini saya buat menggunakan php:8.2-fpm + NGINX

## Donasi

- jika kalian suka dengan projek saya dan ingin support saya, bisa donasi via transfer
  - Jago/Jago Syariah bank digital 5055-6459-9169
