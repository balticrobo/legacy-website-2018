INSERT INTO events VALUES
  (1, '2018', 1527271200, 1525125600, 1526421599, 1527318000, 0, null);

INSERT INTO competition_groups VALUES
  (1, 'Sumo', 'sumo', 1, 1),
  (2, 'Line Follower', 'line_follower', 1, 2),
  (3, 'Freestyle', 'freestyle', 1, 3),
  (4, 'Micromouse', 'micromouse', 1, 4),
  (5, 'LEGO', 'lego', 1, 5),
  (6, 'Robohackathon', 'robohackathon', 1, 6),
  (7, 'Conference', 'conference', 0, null);

INSERT INTO competitions VALUES
  (1, 1, 'Sumo', 'sumo', 1),
  (2, 1, 'miniSumo', 'minisumo', 1),
  (3, 1, 'microSumo', 'microsumo', 1),
  (4, 1, 'nanoSumo', 'nanosumo', 1),
  (5, 2, 'Line Follower Standard', 'line-follower-standard', 1),
  (6, 2, 'Line Follower Turbo', 'line-follower-turbo', 1),
  (7, 2, 'Line Follower Enhanced', 'line-follower-enhanced', 1),
  (8, 2, 'Line Follower Drag', 'line-follower-drag', 1),
  (9, 2, 'Line Follower 3D', 'line-follower-3d', 1),
  (10, 3, 'Freestyle', 'freestyle', 1),
  (11, 4, 'Micromouse 8x8', 'micromouse-8x8', 1),
  (12, 4, 'Micromouse 16x16', 'micromouse-16x16', 1),
  (13, 5, 'LEGO Sumo', 'lego-sumo', 1),
  (14, 5, 'LEGO Line Follower', 'lego-line-follower', 1),
  (15, 6, 'Robohackathon', 'robohackathon', 2),
  (16, 7, 'Conference', 'conference', 3);

INSERT INTO event_competitions VALUES
  (1, 1, 1),
  (2, 1, 2),
  (3, 1, 3),
  (4, 1, 4),
  (5, 1, 5),
  (6, 1, 6),
  (7, 1, 7),
  (8, 1, 8),
  (9, 1, 9),
  (10, 1, 10),
  (11, 1, 12),
  (12, 1, 13),
  (13, 1, 14),
  (14, 1, 15),
  (15, 1, 16);
