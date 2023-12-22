FROM alpine:3.15

RUN echo "http://mirrors.aliyun.com/alpine/v3.15/community" >> /etc/apk/repositories

# Installez Node.js directement avec APK
RUN apk --no-cache add nodejs npm

WORKDIR /app

CMD ["node"]