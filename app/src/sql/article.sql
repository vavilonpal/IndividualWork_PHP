CREATE TABLE articles (
                          id SERIAL PRIMARY KEY,
                          title VARCHAR(255) NOT NULL,
                          content TEXT NOT NULL,
                          category VARCHAR(100),
                          tags VARCHAR(255),
                          author_id INT,
                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          updated_at TIMESTAMP,
                          FOREIGN KEY (author_id) REFERENCES users(id)
);