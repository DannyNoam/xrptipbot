FROM mariadb:latest

ENV MYSQL_ROOT_PASSWORD Password1
ENV MYSQL_DATABASE CSC_TIPS_DB

ADD db.sql /docker-entrypoint-initdb.d/sl_dump_file.sql