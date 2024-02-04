CREATE TABLE events (
	event_id UUID NOT NULL
		PRIMARY KEY,
	user_id UUID NOT NULL
		CONSTRAINT fk_events_user
			REFERENCES users (user_id)
			ON UPDATE restrict
			ON DELETE restrict,
	event_type_id INTEGER NOT NULL
		CONSTRAINT fk_events_event_type
			REFERENCES event_types (event_type_id)
			ON UPDATE cascade,
	event_time TIMESTAMP NOT NULL,
	created_at TIMESTAMP NOT NULL
		DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP NOT NULL,
	CONSTRAINT uq_event
		UNIQUE (user_id, event_time)
);