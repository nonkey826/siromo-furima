CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "postal_code" varchar,
  "address" varchar,
  "building" varchar
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "profiles"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "nickname" varchar not null,
  "avatar" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "profiles_user_id_unique" on "profiles"("user_id");
CREATE TABLE IF NOT EXISTS "items"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "title" varchar not null,
  "description" text not null,
  "price" integer not null,
  "image" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  "is_sold" tinyint(1) not null default '0',
  "category" varchar,
  "status" varchar,
  "brand" varchar,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "favorites"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "item_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("item_id") references "items"("id") on delete cascade
);
CREATE UNIQUE INDEX "favorites_user_id_item_id_unique" on "favorites"(
  "user_id",
  "item_id"
);
CREATE TABLE IF NOT EXISTS "comments"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "item_id" integer not null,
  "comment" text not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("item_id") references "items"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "purchases"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "item_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  "address_id" integer,
  foreign key("item_id") references items("id") on delete cascade on update no action,
  foreign key("user_id") references users("id") on delete cascade on update no action,
  foreign key("address_id") references "addresses"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "addresses"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "zipcode" varchar not null,
  "prefecture" varchar,
  "city" varchar,
  "street" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references users("id") on delete cascade on update no action
);
CREATE UNIQUE INDEX "addresses_user_id_unique" on "addresses"("user_id");

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_12_11_153029_create_profiles_table',1);
INSERT INTO migrations VALUES(5,'2025_12_11_153229_create_addresses_table',1);
INSERT INTO migrations VALUES(6,'2025_12_11_153303_create_items_table',1);
INSERT INTO migrations VALUES(7,'2025_12_11_153401_create_purchases_table',1);
INSERT INTO migrations VALUES(8,'2025_12_11_153435_create_favorites_table',1);
INSERT INTO migrations VALUES(9,'2025_12_12_152930_create_comments_table',1);
INSERT INTO migrations VALUES(10,'2025_12_13_123200_add_is_sold_to_items_table',1);
INSERT INTO migrations VALUES(11,'2025_12_13_204704_add_address_id_to_purchases_table',1);
INSERT INTO migrations VALUES(12,'2025_12_14_075525_add_category_and_status_to_items_table',1);
INSERT INTO migrations VALUES(13,'2025_12_14_084940_add_brand_to_items_table',1);
INSERT INTO migrations VALUES(14,'2025_12_17_131548_add_address_columns_to_users_table',2);
INSERT INTO migrations VALUES(15,'2025_12_19_162544_change_prefecture_nullable_in_addresses',3);
INSERT INTO migrations VALUES(16,'2025_12_19_162831_modify_all_notnull_columns_in_addresses',4);
