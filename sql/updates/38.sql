ALTER TABLE `account_extend`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `account_groups`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `f_categories`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `f_forums`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `f_markread`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `f_posts`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `f_topics`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `online`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `pms`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `site_regkeys`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `site_settings`  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

UPDATE `site_settings` SET `value` = 'utf-8' WHERE CONVERT( `site_settings`.`key` USING utf8 ) = 'site_encoding' LIMIT 1 ;