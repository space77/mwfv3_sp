delete from `site_settings` where key in ('screenshots_path', 'wallpapershots_path');
insert into `site_settings`(`key`,`value`,`desc`,`type`) values ( 'screenshots_path','images/screenshots/',NULL,'string');
insert into `site_settings`(`key`,`value`,`desc`,`type`) values ( 'wallpapers_path','images/wallpapers/',NULL,'string');