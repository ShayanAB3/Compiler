# Используем базовый образ Ubuntu
FROM ubuntu:latest

# Устанавливаем зависимости
RUN apt update && apt install -y \
    g++ cmake make \
    nlohmann-json3-dev\
    default-jdk \
    php-cli php-mbstring php-xml php-curl \
    python3 python3-pip

# Устанавливаем рабочую директорию
WORKDIR /app

# Копируем весь код проекта
COPY . /app

# Открываем порты (если используется сервер PHP или Python)
EXPOSE 8000 8080

# Устанавливаем переменные окружения
ENV JAVA_HOME=/usr/lib/jvm/default-java

# Указываем команду запуска контейнера (можно переопределять при запуске)
CMD ["/bin/bash"]


# create image: docker build -t my_app .
# run command image docker run --rm my_app bash -c "<!bash command!>"
# run test: php ./vendor/phpunit/phpunit/phpunit test/Unit