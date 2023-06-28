<?php
require_once("dao/RegistrationDAO.php");

$registrationDAO = new RegistrationDAO($conn, $BASE_URL);

if (empty($event->images)) {
    $event->images = "event_cover.png";
}

// Get the payment status
$paymentStatus = $registrationDAO->getPaymentStatus($userData->idusers, $event->idevents);
?>

<div class="card event-card">
    <div class="card-img-top"
        style="background-image: url('<?= $BASE_URL ?>img/event/<?= isset($event->images) ? $event->images : 'event_cover.png' ?>')">
    </div>
    <div class="card-body">
        <p class="card-rating">
            <i class="fas fa-star"></i>
            <span class="rating">
                <?= isset($event->rating) ? $event->rating : 'Sem classificação' ?>
            </span>
        </p>
        <h5 class="card-title">
            <a href="<?= $BASE_URL ?>event.php?id=<?= $event->idevents ?>"><?= $event->title ?></a>
        </h5>
        <a href="<?= $BASE_URL ?>event.php?idevents=<?= $event->idevents ?>"
            class="btn btn-primary rate-btn">Avaliar</a>
        <a href="<?= $BASE_URL ?>event.php?idevents=<?= $event->idevents ?>"
            class="btn btn-primary card-btn">Conhecer</a>

        <!-- Check if the event is already paid -->
        <?php if ($paymentStatus != 'pago'): ?>
            <!-- If not paid, display the "Confirm Payment" button -->
            <form method="POST" action="confirmPayment.php">
                <input type="hidden" name="events_idevents" value="<?= $event->idevents ?>">
                <button type="submit" class="btn btn-success card-body">Confirmar Pagamento</button>
            </form>

        <?php else: ?>
            <!-- If already paid, display the "Paid Event" message -->
            <p class="paid-message btn-success card-body">Evento Pago</p>
        <?php endif; ?>

    </div>
</div>