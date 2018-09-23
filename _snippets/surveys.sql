-- competition
SELECT
  CONCAT_WS(" ", u.forename, u.surname)        AS `twórca`,
  COUNT(DISTINCT member.id)                    AS `członków zespołu`,
  team.name                                    AS `nazwa zespołu`,
  COUNT(DISTINCT construction.id)              AS `ilość robotów`,
  GROUP_CONCAT(DISTINCT c.name SEPARATOR ", ") AS `konkurencje`,
  FROM_UNIXTIME(s.created_at)                  AS `data wypełnienia ankiety`,
  s.survey                                     AS `odpowiedzi z ankiety`
FROM registration_surveys s
  JOIN users u on s.created_by_id = u.id
  JOIN registration_teams team on u.id = team.created_by_id
  JOIN registration_members member on team.id = member.team_id
  JOIN registration_constructions construction on team.id = construction.team_id
  JOIN registration_constructions_competitions competition on construction.id = competition.construction_id
  JOIN competitions c on competition.competition_id = c.id
GROUP BY team.id, s.id

UNION
-- hackathon
SELECT
  CONCAT_WS(" ", u.forename, u.surname) AS `twórca`,
  COUNT(DISTINCT member.id)             AS `członków zespołu`,
  team.name                             AS `nazwa zespołu`,
  0                                     AS `ilość robotów`,
  ''                                    AS `konkurencje`,
  FROM_UNIXTIME(s.created_at)           AS `data wypełnienia ankiety`,
  s.survey                              AS `odpowiedzi z ankiety`
FROM registration_surveys s
  JOIN users u on s.created_by_id = u.id
  JOIN registration_teams_hackathon team on u.id = team.created_by_id
  JOIN registration_members_hackathon member on team.id = member.team_id
GROUP BY team.id, s.id

