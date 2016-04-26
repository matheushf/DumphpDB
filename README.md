#DumphpDB

**DumphpDB is a easy way to save and import your working database, with two clicks in a single page**

If you have are working on a new project, it means that, like always, your database is going to have a lot of versions, with the progress we make, we always find something we want to change. 

So if you work in more than one place, or in a team, you probably use a git to save your work, and then pull the changes. 
This plugin allows you to save your current database, and then upload it along with your current project's directory's, and then after pulling your commit, you just update the database, with just two clicks in a single page, and this is it!

##Usage

Inside somewhere in your project,
```
git clone https://github.com/matheushf/DumphpDB.git
cd DumphpDB
```

In conf.json, set the credentials of your mysql, and the database you want to export\import
```
{"host":"localhost","user":"root","pass":"root","database":"","version":1}
```

In your browser, go to the index of DumphpDB, and enjoy!

***@todo***
- Alert if the Database is connected, or if it is not
- If conf.json doesn't exists, create it in the first access to the app
- Give option to download the database in save action
