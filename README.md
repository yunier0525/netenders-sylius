# netenders-sylius

This code chanlenge is based on the test of Netenders

Description of test:

## Technical Test v1.0

### Sylius version


The test
As a sylius developer you’re asked to create a newsletter subscription system in Sylius for the company A. Currently a Customer in Sylius can just check a boolean to receive or not the newsletters. We would like to extend this and allow our customers to subscribe to the newsletters they are interested in (“Newsletter 1”, “Newsletter 2”, ...). 

As a customer I should be able to choose (check/uncheck) the newsletter I want to read when I create or manage my account. The list of chosen newsletters should be sent in the registration email as a confirmation.

As an administrator, I should be able to manage my newsletters (CRUD) and for each newsletter see the list of subscribers. (A newsletter has a subject and a content).

A simple but smart (because company A has hundreds of thousands subscribers) command should be created to send a newsletter to its subscribers (using the newsletter ID as parameter). 

The newsletter 1 should contain this : 
Hi {{firstname}},
You are receiving this email because you have subscribed to {{newsletter name}}. 
Netenders.


#### Bonus
Company A needs to be compliant with the law and wants a system to allow its customers to unsubscribe with one click from a newsletter using a unique link.

Hi {{firstname}},
You are receiving this email because you have subscribed to {{newsletter name}}. <br>
Netenders.<br>
You can unsubscribe from this newsletter by clicking here.

### How we will evaluate you
Criterias that will be evaluated are :
- Good knowledge and usage of Sylius and Symfony
- Reusable code and well factorized 
- Simple and concise code
- Good usage of Doctrine and forms.
- How to proceed
- The whole test should take about 4h for a senior developer, you return the test once you are done.
- How to return the test
- Using GIT, just push your code to a public repository on the platform you are comfortable with (github, gitlab, bitbucket, ...). Send us an email (or Slack) with the link to the repository.

### About the code you write
As coders, the code you write is your intellectual property and belongs to you only; we will not use it in any matter outside this Technical Test. 


## Solution
I implemented the solution using Symfony 6 and EasyAdmin Bundle 4. 

### Install 
Place the repository code in a web server with PHP >= 8.0.2.

#### Install dependencies
- composer install
- npm install

#### Compile assets
- npm run dev

### Config
Make a copy from .env to .env.local and setup your environment in that file.

### Database
Create the database and migrate
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate

## Description of Features
- You can manage the Newsletter from /admin and if you add a new newsletter it will be shown on the register form.
- To register enter to /register and select all the newsletter you want. Once you registered a email must be sended and inform you about the registration on the newsletters.
- From the newsletters admin, in the detail page you can see the users subscribed to the newsletter.
- To send newsletters to subscribers use the custom command: php bin/console send-newsletters <id>|all
- To send mails use this command: php bin/console messenger:consume
