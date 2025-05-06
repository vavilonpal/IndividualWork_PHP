INSERT INTO users (username, email, password, role, created_at)
VALUES
    ('user1', 'user1@example.com', crypt('password1', gen_salt('bf')), 'admin', NOW()),
    ('user2', 'user2@example.com', crypt('password2', gen_salt('bf')), 'user', NOW()),
    ('user3', 'user3@example.com', crypt('password3', gen_salt('bf')), 'user', NOW()),
    ('user4', 'user4@example.com', crypt('password4', gen_salt('bf')), 'user', NOW()),
    ('user5', 'user5@example.com', crypt('password5', gen_salt('bf')), 'user', NOW()),
    ('user6', 'user6@example.com', crypt('password6', gen_salt('bf')), 'user', NOW()),
    ('user7', 'user7@example.com', crypt('password7', gen_salt('bf')), 'user', NOW()),
    ('user8', 'user8@example.com', crypt('password8', gen_salt('bf')), 'user', NOW()),
    ('user9', 'user9@example.com', crypt('password9', gen_salt('bf')), 'user', NOW()),
    ('user10', 'user10@example.com', crypt('password10', gen_salt('bf')), 'user', NOW()),
    ('user11', 'user11@example.com', crypt('password11', gen_salt('bf')), 'user', NOW()),
    ('user12', 'user12@example.com', crypt('password12', gen_salt('bf')), 'user', NOW()),
    ('user13', 'user13@example.com', crypt('password13', gen_salt('bf')), 'user', NOW()),
    ('user14', 'user14@example.com', crypt('password14', gen_salt('bf')), 'user', NOW()),
    ('user15', 'user15@example.com', crypt('password15', gen_salt('bf')), 'user', NOW());
