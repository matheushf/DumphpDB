#DumphpDB

**DumphpDB is a easy way to save and import your working database, with two clicks in a single page**

If you have are working on a new project, it means that, like always, your database is going to have a lot of versions, with the progress we make, we always find something we want to change. 

So if you work in more than one place, or in a team, you probably use a git to save your work, and then pull the changes. 
This plugin allows you to save your current database, and then upload it along with your current project's directory's, and then after pulling your commit, you just update the database, with just two clicks in a single page, and this is it!

##Instalation

Inside somewhere in your project,
```
git clone https://github.com/matheushf/DumphpDB.git
cd DumphpDB
```
Or Zip Download it.

##Usage

In your browser, go to the index of DumphpDB, if it is the first time you are using DumphpDB, you will be asked for the credentials to access mysql, and the database you want to use.

After you submit, you will be able to use it. Hope you enjoy! 

##How it Works

If you work with Git, after you make the first "Save" in DumphpDB, go to your git, make commit/push, in the other computer, make pull, your database will come along with all updated files (as usual), now go to DumphpDB directory, click "Update", now you will see that both databases will be the same.

If you are using it in a remote server (ftp, sftp etc), install DumphpDB in all hosts you will use, and after Saving your database, the only files you need to copy is the "db/" folder, and the "version.json" file, replace them in the remote host, go to DumphpDB index in your browser, now you cand update.

###Any questions

Open an issue, or send me an email

hffmatheus@gmail.com

***@todo***
- Give option to download the database in save action
- Give the version.json file multiple database versions
