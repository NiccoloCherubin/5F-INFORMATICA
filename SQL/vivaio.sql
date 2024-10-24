-- punto 1 --> Visualizzare pianta senza ripetizioni

select distinct r.id, r.nome_latino, r.nome_comune, r.esotica, r.fornitore_id from vivaio.report r order by r.id asc;

-- punto 2 --> Visualizzare fornitori senza ripetizioni

select distinct r.fornitore_id , r.partita_iva , r.codice_fiscale , r.nome, r.cognome, r.indirizzo, r.cap, r.comune, r.provincia from vivaio.report r order by fornitore_id asc;

-- punto 3 --> Visualizzare da quanti fornitori viene fornita una pianta al vivaio

select r.nome_comune, count(r.fornitore_id) as N_Fornitori from vivaio.report r group by r.id ;

-- punto 4 --> Visualizzare quante piante fornisce ogni fornitore

select  fornitore_id, count(r.id) as PianteFornite from vivaio.report r group by r.fornitore_id ;