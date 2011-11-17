# 1.0

Initial release, before refactoring Banner to has_one Image

# 1.1

Refactored Banner to has_one Image, you will need run the following SQL to migrate.

    UPDATE Banner SET ImageID = ID;
    UPDATE File SET ClassName = 'BetterImage' WHERE ID IN (SELECT ID FROM Banner);
