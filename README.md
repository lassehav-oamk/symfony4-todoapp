# Symfony 4 todo list application example 

This project is an example of a classic todo list implementation with Symfony 4

## Prerequisites
  - [Virtual Box (or similar)](https://www.virtualbox.org/wiki/Downloads )
  - [Vagrant](https://www.vagrantup.com/)
  
Also some Vagrant plugins are required
```sh
$ vagrant plugin install vagrant-vbguest  
$ vagrant plugin install vagrant-winnfsd 
```

## Post installation startup commands

First clone this repository and then execute following steps in the folder where you cloed the repo.

Start Vagrant (note! this will take a while on the first time when everything is downloaded)
```sh
$ vagrant up
```

If everything went correct, you should now be able to see the entry page of the application here:
 http://localhost:4567/
 
