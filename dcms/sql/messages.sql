INSERT INTO mmg_lng_messages (msg_code, lang, msg_text) 
VALUES 

('EXCEPTION_PERMISSION_DENIED_TITLE', 'ru', 'Доступ запрещен'),
('EXCEPTION_PERMISSION_DENIED_TITLE', 'en', 'Permission denied'),

('EXCEPTION_PERMISSION_DENIED_BODY', 'ru', 'У вас нет доступа для выполнения данной операции. Возможно вы перешли по некорректной ссылке.'),
('EXCEPTION_PERMISSION_DENIED_BODY', 'en', 'You dont have permissions to complete this action.'),

('TO_POST_COMMENT_YOU_NEED_TO_AUTHORIZE_FIRST', 'ru', 'Чтобы оставлять комментарии необходимо авторизоваться'),
('TO_POST_COMMENT_YOU_NEED_TO_AUTHORIZE_FIRST', 'en', 'If you want to send comments, you need to log on first.'),

('LOG_IN', 'ru', 'Вход'),
('LOG_IN', 'en', 'Enter'),

('USERNAME', 'ru', 'Имя пользователя'),
('USERNAME', 'en', 'Username'),

('PASSWORD', 'ru', 'Пароль'),
('PASSWORD', 'en', 'Password'),

('REMEMBER_ME', 'ru', 'Запомнить меня'),
('REMEMBER_ME', 'en', 'Remember Me'),

('MESSAGES', 'ru', 'Сообщений'),
('MESSAGES', 'en', 'Messages'),

('USER_FROM', 'ru', 'Откуда'),
('USER_FROM', 'en', 'From'),

('USER_RATING', 'ru', 'Рейтинг'),
('USER_RATING', 'en', 'Rating'),

('MESSAGE', 'ru', 'Сообщение'),
('MESSAGE', 'en', 'Message'),

('SEND_MESSAGE', 'ru', 'Отправить'),
('SEND_MESSAGE', 'en', 'Send'),	

('CLEAR', 'ru', 'Очистить'),
('CLEAR', 'en', 'Clear'),

('POSTED_BY', 'ru', 'от'),
('POSTED_BY', 'en', 'by'),

('EDIT', 'ru', 'Редактировать'),
('EDIT', 'en', 'Edit'),

('USER_GROUP', 'ru', 'Группа'),
('USER_GROUP', 'en', 'Group') ON DUPLICATE KEY UPDATE msg_text = VALUES(msg_text);