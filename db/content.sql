insert into tl_liens values
(1, 'https://cvtic.unilim.fr/', 'Campus Virtuel TIC', 'Site internet du CvTIC.', 1), 
(2, 'https://duckduckgo.com/', 'Duck Duck Go', 'Le moteur de recherche qui ne trace pas ses utilisateurs.', 1),
(3, 'https://framasoft.org/', 'Framasoft', 'Un réseau dédié à la promotion du « libre » en général et du logiciel libre en particulier.', 1);

/* raw password is 'adminpass' */
insert into tl_users values
(1, 'admin', 'LsJKppRTEPz4uKrkhScOE6HBSvHuaIcFbAX9FWC7h/f5HffX4TBcFt7p8M0hqvGzFXL+JV8TzEYePoimaosfMQ==', '>=28!7NLw!S37zLjs7Uu[nC', 'ROLE_ADMIN');

insert into tl_tags values
(1, 'fac'), 
(2, 'vieprivee'),
(3, 'opensource'),
(4, 'apprendre');

insert into tl_tags_liens values
(1, 1), 
(2, 2),
(3, 2),
(3, 3),
(4, 1),
(4, 3);