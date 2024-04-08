## Peasy.io Code Test

- [x] Create a Laravel cron job which will run every hour, the job will:
    - [x] call the following API (https://randomuser.me/api/?results=20) to capture 20 user records, and store them into
      the database (using activerecord and Postgresql)
    - [x] To prevent duplicate entry, your code will check each user’s uuid property before storing the record into the
      database. If the uuid already exists, your code will merely update the user’s attribute.
    - [x] Your code will also store the total number of male and female record into redis
- [x] Create a Laravel job which will run at the end of day, the job will:
    - [x] Tabulate the total number of male and female records capture within the day from Redis
    - [x] Store the said total into the DailyRecord table
    - [x] Code your DailyRecord model object so that whenever male_count and female_count attribute is changed, your
      code will calculate the average age of all male and female records in the User table and store them into the
      male_avg_age and female_avg_age attribute.
- [x] Create a simple user interface to:
    - [x] Display a table of all users (name, age, gender, created_at) (with search and delete functionality). When the
      user delete an User record, your code must update either the male_count/female_count attribute in the DailyRecord
      table.
    - [x] Show the total number of user records on screen (a)
    - [x] Display a simple report to display a list of DailyRecord (date, male_avg_count, female_avg_count,
      male_avg_age, female_avg_age)
- [x] You must deploy your working code in your own computer and server for functional presentation
- [x] Commit your code into a git repository and share it with benjamin.fong@peasy.ai
