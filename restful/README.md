# Restful
School project with the goal to build a REST API with a given database

Tools used:
* Ruby <3
* Rack
* Grape
* Sequel
* Capistrano

# Installation

```
$ gem install rerun rack capistrano
$ bundle install
```

# Configuration

Setup database informations :

```
cp .env.example .env
```

open `.env` file and setup your mysql credentials

```
export DB_USERNAME=change_me
export DB_PASSWORD=change_me
```

Now create a database named `restful` and `restful_test` and inject the sql file :

```
$ mysql restful < database.sql
$ mysql restful_test < database.sql
```

Then you can run the development server by running :

```
$ ./dev_server.sh
```

# Run tests

```
$ rspec
```
