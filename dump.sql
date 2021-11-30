--
-- PostgreSQL database dump
--

-- Dumped from database version 11.14
-- Dumped by pg_dump version 14.0

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: admin; Type: TABLE DATA; Schema: public; Owner: main
--

COPY public.admin (id, username, roles, password) FROM stdin;
1	admin	["ROLE_ADMIN"]	$2y$13$25ivE49DNTd9RkGBIwjXEeaqDJIk.UhxQFcaUcLGvJLd5btrh9z8u
\.


--
-- Data for Name: theme; Type: TABLE DATA; Schema: public; Owner: main
--

COPY public.theme (id, category, year, is_international, slug) FROM stdin;
1	Star Wars	1977	t	star-wars-1977
2	Magic: The Gathering	2014	f	magic-the-gathering-2014
\.


--
-- Data for Name: comment; Type: TABLE DATA; Schema: public; Owner: main
--

COPY public.comment (id, theme_id, author, text, email, created_at, photo_filename, state) FROM stdin;
22	1	SebF33	0000000000000000000	sebastien.flouriot@gmail.com	2021-11-29 02:35:47	\N	potential_spam
23	2	SebF33	Bonjour lundi	sebastien.flouriot@gmail.com	2021-11-29 12:47:37	\N	ham
18	2	SebF33	1	sebastien.flouriot@gmail.com	2021-11-29 01:27:20	9f17db627599.jpg	published
19	1	SebF33	test ham	sebastien.flouriot@gmail.com	2021-11-29 01:54:57	\N	published
20	1	SebF33	coucougnette	sebastien.flouriot@gmail.com	2021-11-29 02:11:08	9e2df143c0e4.jpg	published
21	2	SebF33	000	sebastien.flouriot@gmail.com	2021-11-29 02:18:15	\N	published
24	1	SebF33	check mail	sebastien.flouriot@gmail.com	2021-11-29 19:48:57	\N	ham
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: main
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20211111172032	2021-11-26 14:12:13	67
DoctrineMigrations\\Version20211119135957	2021-11-26 14:12:13	10
DoctrineMigrations\\Version20211120172828	2021-11-26 14:12:13	6
DoctrineMigrations\\Version20211124161320	2021-11-26 14:12:13	22
DoctrineMigrations\\Version20211126085901	2021-11-26 14:12:13	3
\.


--
-- Data for Name: messenger_messages; Type: TABLE DATA; Schema: public; Owner: main
--

COPY public.messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) FROM stdin;
\.


--
-- Name: admin_id_seq; Type: SEQUENCE SET; Schema: public; Owner: main
--

SELECT pg_catalog.setval('public.admin_id_seq', 1, false);


--
-- Name: comment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: main
--

SELECT pg_catalog.setval('public.comment_id_seq', 24, true);


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: main
--

SELECT pg_catalog.setval('public.messenger_messages_id_seq', 12, true);


--
-- Name: theme_id_seq; Type: SEQUENCE SET; Schema: public; Owner: main
--

SELECT pg_catalog.setval('public.theme_id_seq', 2, true);


--
-- PostgreSQL database dump complete
--

