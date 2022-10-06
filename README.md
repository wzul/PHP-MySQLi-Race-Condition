# PHP MySQLi - Race condition 🏁

This repository demonstrate the possibility of dealing with concurrency using *Pessimistic locking*.

```text
Pessimistic locking assumes that database transaction conflict is very likely to happen. It locks the record until the transaction is done. If the record is currently lock and the other user make a transaction, that second transaction will wait until the lock in first transaction is release.
```

This is done by simulating complex business logic that might take sometimes to execute using `sleep(30)` where it will sleep for 30 seconds. It should be long enough for you to execute the second file to simulate the concurrency ✌️.

The only difference between `race_1.php` and `race_2.php` is the call to `sleep` function where `race_1.php` does have and `race_2.php` does not.

The execution must be made with `race_1.php` first and immediately `race_2.php` before the `race_1.php` complete the execution. You will notice the `race_2.php` will behave like it is sleeping but, it is actually waiting for `race_1.php` to release the lock.

## Demonstration setup and how-to

1. Import `db.sql` to your mysql.
1. Configure your mysql credentials in `mysql.php`
1. Open first terminal and execute:

    ```bash
    php race_1.php 
    ```

1. Open second terminal and execute:

    ```bash
    php race_2.php
    ```

1. The first terminal output should be: *PATIN2A*
1. The second terminal output should be: *PATIN2AA*
1. You may interested to checkout using phpMyAdmin to confirm the result.
1. Enjoy! 😄😄

## Where does this matters? 🤔

- As an example, if you are doing a simple voting plugin for WordPress to ensure every votes counts, you need to have this locking mechanism in place. Every vote matters. Right? 😄
- If you are developing payment plugin where redirection and webhook may happened concurrently, this is the mechanism you need to applied to avoid multiple execution for delivering orders.
- and many more!

## Simplest Alternative

The simplest way to acquire a lock (removing concurrency) is by using **GET_LOCK**. The lock will valid for the lifetime of the connection and also the timeout whichever earlier.

    ```sql
    SELECT GET_LOCK('spell_payment', 15);
    SELECT RELEASE_LOCK('spell_payment');
    ```

## Screenshot

![Terminal](/images/terminal.png)
![phpMyAdmin](/images/phpmyadmin.png)

## Credits

This demonstration is made possible by:

- <https://gist.github.com/ryanermita/464bf88e2fc292e75c9353820c2f0475>
- <https://www.w3schools.com/php/func_mysqli_fetch_all.asp>
- <https://dev.mysql.com/doc/refman/8.0/en/innodb-locking-reads.html>
- <https://stackoverflow.com/questions/22846438/why-does-select-for-update-works-only-within-a-transaction>
- <https://stackoverflow.com/questions/4284524/how-and-when-to-use-sleep-correctly-in-mysql>
- <https://stackoverflow.com/questions/12091971/how-to-start-and-end-transaction-in-mysqli>
- <https://wordpress.stackexchange.com/questions/247128/transaction-when-using-wp-functions-rather-than-vanilla-sql>
