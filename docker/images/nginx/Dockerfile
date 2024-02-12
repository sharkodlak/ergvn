FROM nginx:latest

COPY ./docker/images/nginx/site.conf /etc/nginx/conf.d/default.conf

RUN apt-get update && \
    apt-get install --no-install-recommends -y \
        less \
        && \
    apt-get -qy autoremove && \
    apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* && \
    rm -rf /tmp/*
