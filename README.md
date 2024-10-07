# Coding assessment - WolfShop Service - PHP Version
_______

### SETUP INSTRUCTION
- Prerequisite:
    - Docker environment installed
    - Docker compose installed
    - (For Windows OS only) Windows Subsystem for Linux installed
- Run application:
    - Copy the .env.example to .env 
    - Paste the CLOUDINARY credentials to .env corresponding
    - At root project dir run `./scripts/startup/run-app.sh`
    - After command finishes setup with successful migration, you are able to access application via `http://localhost:8080`
    - Command to import item: `docker exec -i wolfshop-app sh -c "php artisan app:import-item"`
    - Post man api for updating `imgUrl` can be found in `WoflShop.postman_collection.json`
    - Want to access to DB? Here is your info:
      - Host: `wolfshop-mysql`
      - Port: `3306`
      - User: `app_user`
      - Password: `app_password`
    - Want to interact with Docker Container? Run: `docker exec -i wolfshop-app sh`
- Run test:
    - At root project dir run `./scripts/tests/run-test.sh` to run full tests
    - Want to run specific test? Run `docker exec -it wolfshop-app sh -c "php artisan test --env=testing --filter={TestClassName}"` where `{TestClassName}` is your specific test file. E.g`ItemImportTest`
- FYI: For the goal: import `Item` to our inventory  from API `https://api.restful-api.dev/objects`.
    - `Quality` doesn't present in response. Make assumption it would be `response['data']['Price'] or $response['data']['price']` property. And set limit for maximum is `80`.
    - `SellIn` doesn't present in response. Make assumption it would be `SellIn = (currentYear - response['data']['year']) * 365`
- ToDo:
    - CI/CD: Plan is running CI/CD via Github Action, skeleton in `.github/workflows/ci-cd.yml`
    - DevOps for Server scalability
## Project features
We have a system in place that updates our inventory for us.

- All items have a `SellIn` value which denotes the number of days we have to sell the items
- All items have a `Quality` value which denotes how valuable the item is
- At the end of each day our system lowers both values for every item

Pretty simple, right? Well this is where it gets interesting:

- Once the sell by date has passed, Quality degrades twice as fast
- The Quality of an item is never negative
- **"Apple AirPods"** actually increases in Quality the older it gets
- The Quality of an item is never more than 50
- **"Samsung Galaxy S23"**, being a legendary item, never has to be sold or decreases in Quality
- **"Apple iPad Air"**, like **"Apple AirPods"**, increases in Quality as its SellIn value approaches;
- `Quality` increases by `2` when there are `10` days or less and by `3` when there are `5` days or less but
- `Quality` drops to `0` after the concert

We have recently signed a supplier of conjured items. This requires an update to our system:

- **"Xiaomi Redmi Note 13"** items degrade in `Quality` twice as fast as normal items

Feel free to make any changes to the `UpdateQuality` method and add any new code as long as everything still works correctly. 
However, do not alter the Item class or Items property as those belong to the goblin in the corner who will insta-rage and one-shot you as he doesn't believe in shared code ownership (you can make the `UpdateQuality` method and `Items` property static if you like, we'll cover for you).

Just for clarification, an item can never have its `Quality` increase above `50`, however **"Samsung Galaxy S23"** is a legendary item and as such its `Quality` is `80` & it never alters.

## Old Folders
- `src` - contains the two classes:
    - `Item.php` - this class should not be changed
    - `WolfService.php` - this class needs to be refactored, and the new feature
## New Folders 
- Changed to `app`
    - `Models\Base\Item.php` - Keep the original code for `src\Item.php`
    - `Services\WolfService.php` - Refactor and update the updateQuality function for `src\WolfService.php`
## 🎯 Goal
- Refactor the `WolfService` class to make any changes to the `UpdateQuality` method and add any new code as long as everything still works correctly.
- Store the `Items` in a storage engine of your choice. (e.g. Database, In-memory)
- Create a console command to import `Item` to our inventory  from API `https://api.restful-api.dev/objects` (https://restful-api.dev/). In case Item already exists by `name` in the storage, update `Quality` for it.
- Provide another API endpoint to upload `imgUrl` via [https://cloudinary.com](https://cloudinary.com/documentation/php_image_and_video_upload) (credentials will be sent in email's attachment) for the `Item`. API should be authentication with basic username/password login. The credentials can be hardcoded.
- Unit testing.

