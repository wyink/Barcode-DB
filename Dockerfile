FROM node:12.19.0
WORKDIR /app
COPY ["package*.json", "./"]
RUN apt update && \
    apt upgrade -y && \
    apt install ncbi-blast+ -y && \
    mkdir -p /usr/local/ncbi/blast/bin && \
    cp /usr/bin/blastn /usr/local/ncbi/blast/bin && \
    npm install
COPY . .
EXPOSE 3000
CMD npm start