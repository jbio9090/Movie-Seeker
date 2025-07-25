CREATE TABLE users (
    user_id         varchar(36)         NOT NULL,
    username        varchar(30)         NOT NULL,
    email           varchar(255)        NOT NULL,
    password_hash   varchar(255)        NOT NULL,
    is_activated    tinyint(1)          DEFAULT 0,
    token           varchar(255)        NOT NULL,
    token_expiry    datetime            NOT NULL,
    created_at      timestamp           DEFAULT current_timestamp()     NOT NULL,
    PRIMARY KEY (user_id)
);


CREATE TABLE watchlist (
    watchlist_id    varchar(36)             NOT NULL,
    user_id         varchar(36)             NOT NULL,
    movie_id        int                     NOT NULL,
    poster_path     varchar(255)            NOT NULL,
    genre_ids       varchar(128)            NOT NULL,
    title           varchar(255)            NULL,
);