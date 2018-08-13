INSERT INTO vpn_lng_messages (msg_code, lang, msg_text) VALUES

('ADD_NEW_COMMENT', 'ru', 'Добавить комментарий'),
('ADD_NEW_COMMENT', 'en', 'Add new comment'),

('COMMENTS', 'ru', 'Комментарии'),
('COMMENTS', 'en', 'Comments'),

('COMMENT_MODERATOR_NOTE', 'ru', 'Примечание модератора'),
('COMMENT_MODERATOR_NOTE', 'en', 'Moderator note'),

('NO_SUCH_COMMENT', 'ru', 'Комментарий не найден'),
('NO_SUCH_COMMENT', 'en', 'No such comment'),

('VOTING_OWN_MESSAGES_PROHIBITED', 'ru', 'Голосовать за собственные сообщения запрещено'),
('VOTING_OWN_MESSAGES_PROHIBITED', 'en', 'You cant vote for your own messages.'),

('ERROR_UPDATING_RATING', 'ru', 'Произошла ошибка при изменении рейтинга.'),
('ERROR_UPDATING_RATING', 'en', 'An error occured during rating update.'),

('TO_POST_COMMENT_YOU_NEED_TO_AUTHORIZE_FIRST', 'ru', 'Для отправки сообщений необходимо авторизоваться'),
('TO_POST_COMMENT_YOU_NEED_TO_AUTHORIZE_FIRST', 'en', 'To post messages you need to authorize.')

ON DUPLICATE KEY UPDATE msg_text = VALUES(msg_text);

INSERT INTO mmg_lng_messages (msg_code, lang, msg_text, javascript) VALUES

('COMMENT_SUCCESSFULLY_SENDED', 'ru', 'Комментарий отправлен',1)

ON DUPLICATE KEY UPDATE msg_text = VALUES(msg_text);