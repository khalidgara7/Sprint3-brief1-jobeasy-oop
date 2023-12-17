function searchOfferByKeywords() {
    const searchText = document.getElementById("keywords").value;
    $.ajax({
        method: "GET",
        url: "./controler/crudOffer.php?searchText=" + searchText,
        success: (result) => {
            showOffer(JSON.parse(result))
        }
    });
}

function showOffer(offers) {
    console.log()

    let offerContainer = document.getElementById("offer-container");
    offerContainer.innerText = "";
    let offersTemps = "";
    offers.forEach((offer) => { // foreach of javascript
        offersTemps +=  `
        <article class="postcard light green">
            <a class="postcard__img_link" href="#">
            <img class="postcard__img" src="https://picsum.photos/300/300" alt="Image Title" />
            </a>
            <div className="postcard__text t-dark">
                <h3 className="postcard__title green"><a href="#">${offer.TitreOffre}</a></h3>
                <div className="postcard__subtitle small">
                    <time dateTime="2020-05-25 12:00:00">
                        <i className="fas fa-calendar-alt mr-2"></i>${offer.DatePublication}
                    </time>
                </div>
                <div className="postcard__bar"></div>
                <div className="postcard__preview-txt"><?= $offer['DescriptionOffre'] ?></div>
                <ul className="postcard__tagbox">
                    <li className="tag__item"><i className="fas fa-tag mr-2"></i><?= $offer['Localisation'] ?></li>
                    <li className="tag__item"><i className="fas fa-clock mr-2"></i>55 mins.</li>
                    <li className="tag__item play green">
                        <form action="" method="post">
                            <input type="hidden" name="job_id" value="${offer.offreId}">
                                <button className="" type="submit" name="apply">
                                    APPLY NOW
                            </button>
                        </form>
    
                    </li>
                </ul>
            </div>
        </article>
        `;
    });

    offerContainer.innerHTML = offersTemps;

}