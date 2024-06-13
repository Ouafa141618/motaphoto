<div class="filters-container">
    <div class="filters">
        <div class="filter">
            <label for="filter-category" class="filter-label">CATEGORIES</label>
            <select name="categories-photos" id="filter-category" class="filter-category">
                <option value="default-category"></option>
                <?php
                $categories = get_categories(array(
                    'taxonomy' => 'categories-photos',
                    'hide_empty' => false,
                ));
                foreach ($categories as $category) {
                    echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="filter">
            <label for="filter-format" class="filter-label">FORMATS</label>
            <select name="formats" id="filter-format" class="filter-format">
                <option value="default-format"></option>
                <?php
                $formats = get_categories(array(
                    'taxonomy' => 'formats',
                    'hide_empty' => false,
                ));
                foreach ($formats as $format) {
                    echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="filter">
            <label for="filter-tri" class="filter-label">TRIER PAR</label>
            <select name="tri" id="filter-tri" class="filter-tri">
                <option value="default-tri"></option>
                <option value="date_desc">Du plus récent au plus ancien</option>
                <option value="date_asc">Du plus ancien au plus récent</option>
            </select>
        </div>
    </div>
</div>
