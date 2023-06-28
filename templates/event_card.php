<?php
    if(empty($event->images)){
        $event->images = "event_cover.png";
    }

?>

<div class="card event-card">
    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/event/<?= isset($event->images) ? $event->images : 'event_cover.png' ?>')"></div>
    <div class="card-body">
        <h5 class="card-title">
            <a href="<?= $BASE_URL ?>event.php?id=<?= $event->idevents ?>"><?= $event->title ?></a>
        </h5>
        <p class="card-rating">
            <i class="fas fa-star"></i>
            <span class="rating"><?= isset($event->rating) ? $event->rating : 'Sem classificação' ?></span>
        </p>
        <a href="<?= $BASE_URL ?>event.php?idevents=<?= $event->idevents ?>" class="btn btn-primary rate-btn">Avaliar</a>
        <a href="<?= $BASE_URL ?>event.php?idevents=<?= $event->idevents ?>" class="btn btn-primary card-btn">Conhecer</a>
    </div>
</div>
