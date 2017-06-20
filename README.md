# cms
Simple CMS posting system.

This is a lightweight plugin to add a CMS system to your webstie. To use, just pull in this repo and then you're done. The cms will then be setup on `http://sitename/cms`.

The default login for the admin system is `username`:`admin`, `password`:`password`. You should change this as soon as you logon by creating a new user.

#### config.php
At the moment, the only bit of setup that must be done is setting you `URI`. By default, this is set to `/cms` and needs more testing before it can be reliably changed.

#### Database
The MySQL DB dump is saved in sql/cms.sql and this is your starting databse. Imprvements are going to be made in the future to make the database management better and easier.

#### Api Calls

There are a few API calls available to you on your frontend site. There is however, one requirement to use them however, which is to `require` the `Api.php` file in the file you wish to use them.

##### getPosts()
The `getPosts()` API call is pretty self-explanatory, it gets all of the posts from your cms.

##### getPost()
`getPost()` gets a singular post using the key indexed array that you pass into it. The key acts as the column name while the value acts as the column value. So to get a post called **Best Post** posted by the user **admin**, you would call `getPost(['title' => 'Best Post', 'posted_by' => 'admin'])`.

##### isPost()
`isPost()` returns a boolean telling you whether or not a post exists depending on the parameters that you pass into it in the same way you would use `getPost()`. So, for example, you wanted to see if a post with id **131** exists, you would call `isPost(['id' => 131])`

#### Future Updates
- [ ] Ability to post videos.
- [ ] Ability to post e-commerce products.
- [ ] Friendlier UI.
- [ ] CMS settings section.
