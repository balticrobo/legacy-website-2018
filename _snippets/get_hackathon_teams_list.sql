SELECT
  t.id AS team_id,
  t.captain_id,
  CONCAT(m.forename, " ", m.surname) AS capitan,
  t.created_by_id,
  CONCAT(u.forename, " ", u.surname) AS created_by,
  u.email AS created_by_email,
  t.name AS team_name,
  t.city AS team_city,
  FROM_UNIXTIME(t.created_at) AS team_created_at,
  t.why_you,
  t.experience
FROM registration_teams_hackathon t
  JOIN registration_members_hackathon m on t.captain_id = m.id
  JOIN users u on t.created_by_id = u.id
;

