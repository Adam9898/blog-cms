# Simple blog system
As the title of the project suggests, this is a blog content management system, in which authors
can publish posts, and the rest of the world can read them.
#### Visitors
Regular visitors can sign up to the service, which allows them to receive automatic notifications
when a new blog post is created and when it is updated/modified.</p>
#### Usage
1. Install docker.
2. Install docker-compose, if it's not included with the regular docker installation.
3. Go to your os hosts file, and add the following line to it: `127.0.0.1 cms.local`
4. Clone the project, and execute the following command in the docker folder: `docker-compose up`
5. Wait until docker-compose sets up the server environment.
6. Open up your favorite web browser, and type into the url bar: `http://cms.local`
7. Enjoy :)

Docker will run a sql script on the first startup, which will setup the mysql database. It will insert
two test users, one is a regular user, the other is an author. It is **important** to note, that the only
way to add editorial permission to a user, is to add a relation in the database. Obviously this could be
done in a much nicer way, but in the end of day, this is just a hobby project of mine with limited time.

email: `regular@test.com`  
password: `Test1234`

email: `editor@test.com`  
password: `Test1234`

Use these accounts to the test the webapp. You will see some random test posts too, which is added with the
sql script.

In order to create a new blog post, head over to `cms.local/blogs/create`  
To edit a particular post, go to `cms.local/blogs/yourblogidhere/edit`

There is no dedicated button for creating a new post, that is why I included the url here.
This could be changed later for a nicer ux.

#### Notes and bugs

The notification system is very basic, and it is done in a synchronised way. You will get the new notifications
live, however they will only be registered as read, once you refresh the page. Again, this is something that
could be improved with a notification api controller, and some ajax magic.

The registration validation could have smaller bugs. One particular I have found was that sometimes when you enter
the same password twice, the form still says that they don't match.

Users can comment to a post, which is only removable by them, and only after refreshing the page after
posting the new comment.

#### For developers

To run the phpunit tests, first enter the workspace docker container: `docker-compose exec workspace bash`
and once you are in the container, run `php artisan test`.

The project itself was written in php, using the laravel (v7) framework. It is a hobby project I created by
myself. The database is mysql, redis is being used as a message broker, and a nodejs websocket server is also running
in a separate docker container.  
The frontend is written is typescript and sass (scss). The blade templating engine is also being utilized.
 **Compiled files are included**.
