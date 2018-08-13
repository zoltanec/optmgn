INSERT INTO mmg_lng_messages (msg_code, lang, msg_text) VALUES 

('FORUM', 'ru', 'Форум'),
('FORUM', 'en', 'Forum'),

('TOPIC_NAME','ru','Название темы'),
('TOPIC_NAME','en','Topic name'),

('AUTHOR', 'ru', 'Автор'),
('AUTHOR', 'en', 'Author'),

('TOTAL_MESSAGES', 'ru', 'Сообщений'),
('TOTAL_MESSAGES', 'en', 'Messages'),

('TOTAL_VIEWS', 'ru', 'Всего просмотров'),
('TOTAL_VIEWS', 'en', 'Views'), 

('LAST_MESSAGE', 'ru', 'Последнее сообщение'),
('LAST_MESSAGE', 'en', 'Last message'),

('STICKED_TOPIC_PREFIX', 'ru', 'Прикреплено'),
('STICKED_TOPIC_PREFIX', 'en', 'Sticked'),

('TOPIC_PAGES', 'ru', 'Страницы'),
('TOPIC_PAGES', 'en', 'Pages'),

('FORUM_HEADER', 'ru', 'Форум'),
('FORUM_HEADER', 'en', 'Forum'),

('FORUM_SECTION_TOPICS', 'ru', 'Темы'),
('FORUM_SECTION_TOPICS', 'en', 'Topics'),

('FORUM_SECTION_NAME', 'ru', 'Название раздела'),
('FORUM_SECTION_NAME', 'en', 'Section name'),

('FORUM_SECTION_TOPICS', 'ru', 'Темы'),
('FORUM_SECTION_TOPICS', 'en', 'Topics'),

('FORUM_CURRENT_SECTION', 'ru', 'Раздел'),
('FORUM_CURRENT_SECTION', 'en', 'Section'),

('FORUM_CREATE_NEW_TOPIC', 'ru', 'Создание темы'),
('FORUM_CREATE_NEW_TOPIC', 'en', 'Create new topic'),

('FORUM_TOPIC_TITLE', 'ru', 'Заголовок темы'),
('FORUM_TOPIC_TITLE', 'en', 'Topic title'),

('FORUM_TOPIC_DESCRIPTION', 'ru', 'Примечание'),
('FORUM_TOPIC_DESCRIPTION', 'en', 'Description'),

('FORUM_TOPIC_MESSAGE', 'ru', 'Сообщение'),
('FORUM_TOPIC_MESSAGE', 'en', 'Message'),

('FORUM_TOPIC_PREVIEW', 'ru', 'Предварительный просмотр'),
('FORUM_TOPIC_PREVIEW', 'en', 'Preview'),

('FORUM_TOPIC_EDIT', 'ru', 'Редактирование темы'),
('FORUM_TOPIC_EDIT', 'en', 'Edit topic'),

('FORUM_POST_TOPIC', 'ru', 'Разместить тему'),
('FORUM_POST_TOPIC', 'en', 'Post'),

('FORUM_STATISTICS', 'ru', 'Статистика форума'),
('FORUM_STATISTICS', 'en', 'Forum statistics'),

('EXCEPTION_NO_SUCH_FORUM_SECTION_TITLE', 'ru', 'Раздел не найден'),
('EXCEPTION_NO_SUCH_FORUM_SECTION_TITLE', 'en', 'No such forum section'),

('EXCEPTION_NO_SUCH_FORUM_SECTION_BODY', 'ru', 'Вы попытались в перейти в раздел, которого не существует. Возможно вам дали плохую ссылку, либо вы ошиблись с набором адреса'),
('EXCEPTION_NO_SUCH_FORUM_SECTION_BODY', 'en', 'You are trying to access non existed section.'),

('EXCEPTION_NO_SUCH_TOPIC_TITLE', 'ru', 'Тема не найдена'),
('EXCEPTION_NO_SUCH_TOPIC_TITLE', 'en', 'No such topic'),

('EXCEPTION_NO_SUCH_TOPIC_BODY', 'ru', 'Тема к которой вы попытались обратиться не найдена. Возможно она была удалена, либо в базе данных произошла ошибка.'),
('EXCEPTION_NO_SUCH_TOPIC_BODY', 'en', 'Unable to find needed topic. Probably some database error.'),

('USERS_ON_FORUM', 'ru', 'Пользователей на форуме'),
('USERS_ON_FORUM', 'en', 'Users on forum'),

('MODERATORS', 'ru', 'Модераторы'),
('MODERATORS', 'en', 'Moderators'),

('GUESTS_COUNT', 'ru', 'Гостей'),
('GUESTS_COUNT', 'en', 'Guests'),

('TO_POST_COMMENT_YOU_NEED_TO_AUTHORIZE_FIRST', 'ru', 'Чтобы оставлять комментарии вам необходимо сначала авторизоваться'),
('TO_POST_COMMENT_YOU_NEED_TO_AUTHORIZE_FIRST', 'en', 'To leave a message you need to authorize first'),

('GOTO', 'ru', 'Перейти'),
('GOTO', 'en', 'Go')

ON DUPLICATE KEY UPDATE msg_text = VALUES(msg_text);