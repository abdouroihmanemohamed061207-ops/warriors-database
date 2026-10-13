
const zoneJoueurs = document.querySelector("#liste-joueurs");
const zoneFiche = document.querySelector("#fiche-joueur");
const zonePalmares = document.querySelector("#liste-titres");

function imageHTML(src, alt) {
    return `<img src="${src}" alt="${alt}"
        loading="lazy"
        onerror="this.style.display='none'">`;
}

function calculerAge(naissance, deces = null) {
    const debut = new Date(naissance + "T12:00:00");
    const fin = deces
        ? new Date(deces + "T12:00:00")
        : new Date();

    let age = fin.getFullYear() - debut.getFullYear();

    if (
        fin.getMonth() < debut.getMonth() ||
        (fin.getMonth() === debut.getMonth() &&
         fin.getDate() < debut.getDate())
    ) {
        age--;
    }
    return age;
}

// PAGE JOUEURS
if (zoneJoueurs) {
    zoneJoueurs.innerHTML = joueurs.map(j => `
        <a class="carte carte-joueur"
           href="joueur.html?id=${j.id}">
            ${imageHTML(j.photo, j.nom)}
            <div class="contenu-carte">
                <span class="numero">#${j.numero}</span>
                <h2>${j.nom}</h2>
                <p class="poste">${j.poste}</p>
                <p>${j.description}</p>
                <span class="texte-decouvrir">
                    Voir sa fiche complète →
                </span>
            </div>
        </a>
    `).join("");
}

// FICHE D'UN JOUEUR
if (zoneFiche) {
    const params = new URLSearchParams(location.search);
    const id = Number(params.get("id"));
    const j = joueurs.find(joueur => joueur.id === id);

    if (!j) {
        zoneFiche.innerHTML = "<p>Joueur introuvable.</p>";
    } else {
        const age = calculerAge(j.naissance, j.deces);

        zoneFiche.innerHTML = `
            <a class="retour-joueurs" href="joueurs.html">
                ← Retour aux joueurs
            </a>

            <section class="profil-joueur">
                <div class="photo-profil">
                    ${imageHTML(j.photo, j.nom)}
                </div>

                <div class="infos-profil">
                    <span class="etiquette">
                        JOUEUR EMBLÉMATIQUE
                    </span>

                    <h1>${j.nom}</h1>
                    <p class="poste-profil">
                        #${j.numero} — ${j.poste}
                    </p>

                    <span class="statut-joueur">${j.statut}</span>

                    <div class="statistiques-joueur">
                        <div><span>Taille</span>
                            <strong>${j.taille}</strong></div>
                        <div><span>${j.deces ? "Âge au décès" : "Âge"}</span>
                            <strong>${age} ans</strong></div>
                        <div><span>Titres NBA</span>
                            <strong>${j.titres}</strong></div>
                        <div><span>Numéro Warriors</span>
                            <strong>#${j.numero}</strong></div>
                    </div>

                    <h2>Franchise actuelle</h2>
                    <p>${j.equipe}</p>

                    <h2>Biographie</h2>
                    <p>${j.description}</p>
                </div>
            </section>

            <section class="section-detail">
                <h2>Son parcours NBA</h2>
                <div class="carte parcours-joueur">
                    ${j.franchises.map(f => `
                        <p>🏀 ${f}</p>
                    `).join("")}
                </div>
            </section>

            <section class="section-detail">
                <h2>Ses maillots</h2>
                <div class="grille-maillots">
                    ${j.maillots.map(src => `
                        <div class="carte carte-maillot">
                            ${imageHTML(src, "Maillot de " + j.nom)}
                        </div>
                    `).join("")}
                </div>
            </section>
        `;
    }
}

// PALMARÈS
if (zonePalmares) {
    zonePalmares.innerHTML = titres.map(t => `
        <article class="carte carte-titre">
            <div class="image-titre">
                ${imageHTML(t.image, "Warriors champions " + t.annee)}
            </div>
            <span class="etiquette">CHAMPION NBA</span>
            <h2>${t.annee}</h2>
            <p><strong>Adversaire :</strong> ${t.adversaire}</p>
            <p><strong>Résultat :</strong> ${t.resultat}</p>

            <div class="zone-video">
                ${t.video
                    ? `<a class="bouton-video"
                          href="${t.video}"
                          target="_blank"
                          rel="noopener noreferrer">
                          ▶ Revivre la finale
                       </a>`
                    : `<p class="video-attente">Vidéo à venir</p>`
                }
            </div>
        </article>
    `).join("");
}
