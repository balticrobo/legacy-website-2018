FROM node:lts

RUN npm install foundation-cli --global

WORKDIR /app

COPY start.sh /opt/docker/
RUN chmod +x /opt/docker/start.sh
CMD ["/opt/docker/start.sh"]
