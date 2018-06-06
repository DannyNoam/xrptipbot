# csctipbot.com

Forked with @WietseWind (thanks for the original code).

# Notes
This is not clean code. This code has largely been munged together, but works quite well.

# How to use
To build this project locally, you'll need to fill in the config files (config.js and config.php) with the relevant
 information (mostly API credentials). Once you've done this, with Docker installed, simply run `docker-compose build`.
  This may take a few minutes, and will build all of the Docker containers. Then simply run `docker-compose up`, and
   go to your Docker host IP (i.e. localhost) with the port exposed (443) appended (e.g. localhost:443) and you should 
   have a fully-functioning TipBot locally!
   
   
# Help! One of my containers has died on me!
Not to worry! Just run `docker-compose up` and it should bring it back to life.
