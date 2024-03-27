CREATE TABLE event_types (
	event_type_id SERIAL NOT NULL
		PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	CONSTRAINT uq_event_types_name
		UNIQUE (name)
);
