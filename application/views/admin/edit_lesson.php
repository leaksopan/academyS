<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Edit Pelajaran</h1>
            <p class="text-muted">Edit pelajaran untuk kursus: <strong><?= $course['title'] ?></strong></p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/lessons?course_id=' . $lesson['course_id']) ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pelajaran
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('lesson_update_failed')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('lesson_update_failed') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Edit Lesson Form -->
    <div class="card">
        <div class="card-body">
            <?= form_open('admin/edit_lesson/' . $lesson['id']) ?>
            <div class="mb-3">
                <label for="title" class="form-label">Judul Pelajaran</label>
                <input type="text" class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= set_value('title', $lesson['title']) ?>">
                <div class="invalid-feedback">
                    <?= form_error('title') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="order_number" class="form-label">Urutan</label>
                <input type="number" class="form-control <?= form_error('order_number') ? 'is-invalid' : '' ?>" id="order_number" name="order_number" value="<?= set_value('order_number', $lesson['order_number']) ?>">
                <div class="invalid-feedback">
                    <?= form_error('order_number') ?>
                </div>
                <small class="text-muted">Urutan pelajaran dalam kursus (1, 2, 3, dst.)</small>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Konten Pelajaran</label>
                <textarea class="form-control <?= form_error('content') ? 'is-invalid' : '' ?>" id="content" name="content" rows="10"><?= set_value('content', $lesson['content']) ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('content') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="video_url" class="form-label">URL Video YouTube</label>
                <input type="text" class="form-control <?= form_error('video_url') ? 'is-invalid' : '' ?>" id="video_url" name="video_url" value="<?= set_value('video_url', isset($lesson['video_url']) ? $lesson['video_url'] : '') ?>">
                <div class="invalid-feedback">
                    <?= form_error('video_url') ?>
                </div>
                <small class="text-muted">Masukkan URL video YouTube (contoh: https://www.youtube.com/watch?v=VIDEO_ID atau https://youtu.be/VIDEO_ID)</small>
            </div>

            <button type="submit" class="btn btn-primary">Perbarui Pelajaran</button>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    // Initialize CKEditor for rich text editing
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('content', {
                height: 400,
                removeButtons: 'About',
                allowedContent: true,
                basicEntities: false,
                entities: false,
                forceSimpleAmpersand: true,
                removePlugins: 'indent,htmlwriter',
                enterMode: CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_BR,
                autoParagraph: false,
                fillEmptyBlocks: false,
                contentsCss: [
                    '<?= base_url("assets/css/ckeditor-content.css") ?>'
                ],
                on: {
                    instanceReady: function(evt) {
                        evt.editor.setData(evt.editor.getData().replace(/^\s+/gm, ''));
                    },
                    change: function(evt) {
                        var data = evt.editor.getData();
                        // Remove leading spaces from each line
                        data = data.replace(/^\s+/gm, '');
                        evt.editor.setData(data, {
                            internal: true
                        });
                    }
                }
            });
        }
    });
</script>

<style>
    /* Styling untuk konten editor */
    .cke_editable {
        white-space: pre-line !important;
        word-wrap: break-word;
        line-height: 1.6;
        padding: 0 !important;
        margin: 0 !important;
        text-indent: 0 !important;
    }

    /* Preview styling */
    .card-text {
        white-space: pre-line !important;
        word-wrap: break-word;
        line-height: 1.6;
        padding: 0 !important;
        margin: 0 !important;
    }
</style>