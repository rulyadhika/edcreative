<?= $this->extend("admin/layout/template"); ?>

<?php $errors = session()->getFlashdata('errors');
$i = 1; ?>

<?= $this->section("main-container"); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Postingan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $page; ?></h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url("admin/postingan/insert") ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="row mb-2">
                <div class="col-md-9">
                    <div class="form-group row">
                        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control <?= isset($errors['judul']) ? ' is-invalid' : ''; ?>" id="judul" name="judul" placeholder="Masukan Judul" value="<?= old('judul'); ?>">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= isset($errors['judul']) ? $errors['judul'] : ''; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control <?= isset($errors['kategori']) ? ' is-invalid' : ''; ?>" id="kategori" name="kategori">
                                <option value="" hidden>-- Pilih Kategori --</option>
                                <?php foreach ($data_kategori as $d) : ?>
                                    <option <?= old('kategori') == $d['id'] ? 'selected' : ''; ?> value="<?= $d['id']; ?>"><?= esc($d['nama_kategori']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= isset($errors['kategori']) ? $errors['kategori'] : ''; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="thumbnail" class="col-sm-2 col-form-label">Thumbnail</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input <?= isset($errors['thumbnail']) ? ' is-invalid' : ''; ?>" id="thumbnail" aria-describedby="inputGroupFileAddon01" name="thumbnail" onchange="previewImg()">
                                    <label class="custom-file-label custom-label" for="thumbnail">Choose
                                        file</label>
                                </div>
                                <div id="validationServer03Feedback" class="invalid-feedback d-block">
                                    <?= isset($errors['thumbnail']) ? $errors['thumbnail'] : ''; ?>
                                </div>
                                <small class="d-block">*Ukuran gambar thumbnail maksimal 1MB. Ekstensi yang diperbolehkan jpg/jpeg/png, <span class="font-weight-bold">disarankan untuk menggunakan jpg/jpeg untuk performa yang lebih baik</span></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <h6>Preview Thumbnail</h6>
                    <img src="<?= base_url("src/images/default.jpg") ?>" class="img-fluid img-preview" alt="">
                </div>
            </div>
            <textarea id="editor" name="content" class="<?= isset($errors['content']) ? ' is-invalid' : '' ?>">
            <?= old('content'); ?>
            </textarea>
            <div id="validationServer03Feedback" class="invalid-feedback">
                <?= isset($errors['content']) ? $errors['content'] : ''; ?>
            </div>
            <small class="font-italic">*Ukuran maksimal gambar konten 1MB. Ekstensi yang diperbolehkan jpg/jpeg/png, <span class="font-weight-bold">disarankan untuk menggunakan jpg/jpeg untuk performa yang lebih baik</span></small>
            <div class="form-group mt-2">
                <button class="btn btn-primary float-right">Tambah Postingan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("pageScript"); ?>
<script src="<?= base_url("src/plugins/ckeditor/build/ckeditor.js") ?>"></script>
<script src="<?= base_url("src/plugins/ckfinder/ckfinder.js") ?>"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: '/src/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
            },
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    '|',
                    'fontFamily',
                    'fontSize',
                    // 'fontBackgroundColor',
                    'fontColor',
                    'highlight',
                    '|',
                    'alignment',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'indent',
                    'outdent',
                    // 'subscript',
                    'superscript',
                    '|',
                    'horizontalLine',
                    'link',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo'
                ]
            },
            language: 'id',
            image: {
                styles: [
                    'alignLeft', 'alignCenter', 'alignRight'
                ],
                toolbar: [
                    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                    '|',
                    'imageResize',
                    '|',
                    'imageTextAlternative'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
            },
            mediaEmbed: {
                'previewsInData': true,
            },
            licenseKey: '',

        })
        .then(editor => {
            window.editor = editor;

        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error(
                'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
            );
            console.warn('Build id: 2ost6bg4aq96-lyzw9duz70y');
            console.error(error);
        });
</script>
<script>
    let previewImg = () => {
        const fileInput = document.querySelector("#thumbnail");
        const customLabel = document.querySelector(".custom-label");
        const imgPreview = document.querySelector(".img-preview");

        customLabel.innerText = fileInput.files[0].name;

        const fileCover = new FileReader();
        fileCover.readAsDataURL(fileInput.files[0]);

        fileCover.onload = (e) => {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?= $this->endSection(); ?>