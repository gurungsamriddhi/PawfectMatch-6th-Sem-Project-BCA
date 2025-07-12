<?php include 'app/views/partials/sidebaradmin.php'; ?>
<!-- Main Content -->
<div class="body-wrapper w-100">
    <!-- Header -->
    <header class="app-header bg-dark text-white py-3 px-4">
        <div class="d-flex justify-content-between align-items-msg">
            <h5 class="mb-0">All contact messages</h5>
            <div class="d-flex align-items-msg gap-3">
                <i class="fas fa-bell"></i>
                <i class="fas fa-msg-circle"></i>
            </div>
        </div>
    </header>
    <!-- Content -->
    <div class="container-fluid py-4">
        <div class="top-actions">
            <div class="filter-group">
                <label for="typeFilter"><i class="fa-solid fa-folder-open"></i> Filter by msgname:</label>
                <select class="filter" id="typeFilter" onchange="filterByType(this)">
                    <option value="All">All</option>
                    <option value="Pokhara">Pokhara</option>
                    <option value="Kathmandu">Kathmandu</option>
                    <option value="Chitwan">Chitwan</option>
                    <option value="Tanahun">Tanahun</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table view-table" id="msgTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Verified</th>
                        <th>Message Submitted Date</th>
                        <th>Reply</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?= htmlspecialchars($msg['name']) ?></td>
                            <td><?= htmlspecialchars($msg['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                            <td>
                                <?php if ($msg['is_verified'] == 1): ?>
                                    <span class="status-badge status-active">Verified</span>
                                <?php else: ?>
                                    <span class="status-badge status-inactive">Not Verified</span>

                                <?php endif; ?>
                            </td>
                            <td><?= date('Y-m-d H:i', strtotime($msg['submitted_at'])) ?></td>
                            <td>
                                <?php if (!empty($msg['reply_message'])): ?>
                                    <?= nl2br(htmlspecialchars($msg['reply_message'])) ?>
                                <?php else: ?>
                                    <span class="status-badge status-pending">Pending</span>

                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button
                                        type="button"
                                        class="btn btn-primary replyBtn"
                                        data-action="reply"
                                        data-message-id="<?= $msg['message_id'] ?>"
                                        data-name="<?= htmlspecialchars($msg['name'], ENT_QUOTES) ?>"
                                        data-email="<?= htmlspecialchars($msg['email'], ENT_QUOTES) ?>"
                                        data-message="<?= htmlspecialchars($msg['message'], ENT_QUOTES) ?>"
                                        data-is-verified="<?= $msg['is_verified'] ?>">
                                        Reply
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Reply Modal -->
            <div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <form id="replyForm" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Send Reply</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="message_id" id="replyMessageId">
                            <input type="hidden" name="email" id="replyEmail">
                            <input type="hidden" name="name" id="replyName">
                            <input type="hidden" name="is_verified" id="replyVerified">
                            <div class="mb-2">
                                <label>Receiver Email</label>
                                <input type="text" class="form-control" id="receiverEmail" readonly>
                            </div>

                            <div class="mb-2">
                                <label>Original Message</label>
                                <textarea id="originalMessage" class="form-control" readonly></textarea>
                            </div>

                            <div class="mb-2">
                                <label>Your Reply</label>
                                <textarea name="reply" class="form-control" id="replyBody" required minlength="5"></textarea>
                            </div>

                            <div id="replyStatus" class="mt-2"></div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php include 'app/views/partials/admin_footer.php'; ?>