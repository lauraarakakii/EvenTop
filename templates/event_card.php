<?php
    if(empty($event->images)){
        $event->images = "event_cover.png";
    }

?>

<div class="card event-card">
    <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/event/<?= $event->images ?>')"></div>
    <div class="card-body">
        <p class="card-rating">
            <i class="fas fa-star"></i>
            <span class="rating">9</span>
        </p>
        <h5 class="card-title">
            <a href="<?= $BASE_URL ?>event.php?id=<?= $event->idevents ?>"><?= $event->title ?></a>
        </h5>
        <a href="<?= $BASE_URL ?>event.php?id=<?= $event->idevents ?>" class="btn btn-primary rate-btn">Avaliar</a>
        <a href="<?= $BASE_URL ?>event.php?id=<?= $event->idevents ?>" class="btn btn-primary card-btn">Conhecer</a>
    </div>
</div>