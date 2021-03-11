SELECT s1.idsetor id, s1.siglasetor sigla, s1.nomesetor nome, s1.tiposetor tipo, o1.idsetorpai
FROM cm_setor s1
LEFT JOIN cm_organograma o1 ON o1.idsetor = s1.idsetor and o1.idtipoorganograma = 1
LEFT JOIN cm_organograma o2 ON o2.idsetor = o1.idsetorpai and o2.idtipoorganograma = 1
LEFT JOIN cm_organograma o3 ON o3.idsetor = o2.idsetorpai and o3.idtipoorganograma = 1
WHERE (s1.idsetor = 10057 OR s1.idsetor = 10132 OR o1.idsetor = 548 OR o2.idsetor = 548 OR o3.idsetor = 548) AND s1.datafim IS NULL;
