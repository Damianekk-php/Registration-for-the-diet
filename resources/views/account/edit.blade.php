@extends('layouts.app')

@section('content')

    <style>


    </style>

    <div class="container">

            <div class="card-header">{{ __('Dane do logowania') }}</div>
            <form method="POST" action="{{ route('account.update') }}">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Imię / Nick') }}</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Adres e-mail') }}</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Nowe hasło') }}</label>
                    <input id="password" type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">{{ __('Potwierdź hasło') }}</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                </div>

                <div class="form-group">
                    <label for="country" class="form-label">{{ __('Kraj') }}</label>
                    <select id="country" class="form-select" name="country">
                        <option value="Polska" {{ old('country', Auth::user()->country) == 'Polska' ? 'selected' : '' }}>Polska</option>
                        <option value="Niemcy" {{ old('country', Auth::user()->country) == 'Niemcy' ? 'selected' : '' }}>Niemcy</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="postal_code" class="form-label">{{ __('Kod pocztowy') }}</label>
                    <input id="postal_code" type="text" class="form-control" name="postal_code" value="{{ old('postal_code', Auth::user()->postal_code) }}">
                </div>

                <button type="submit" class=" btn-success">{{ __('Zapisz') }}</button>
            </form>


            <div class="card-header">{{ __('Ankieta') }}</div>
            <form method="POST" action="{{ route('account.survey.store') }}">
                @csrf
                <h3 class="text-center">Ankieta</h3>

                <div class="mb-4">
                    <label for="gender" class="form-label">Płeć</label><br>
                    <input type="radio" id="gender_male" name="gender" value="Mężczyzna" onchange="togglePregnancyFields()"> Mężczyzna
                    <input type="radio" id="gender_female" name="gender" value="Kobieta" onchange="togglePregnancyFields()"> Kobieta
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3">Dane obowiązkowe</h4>
                        <div class="mb-3">
                            <label for="height" class="form-label">Wzrost (cm)</label>
                            <input type="number" id="height" name="height" class="form-control"
                                   value="{{ old('height', Auth::user()->height ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Waga (kg)</label>
                            <input type="number" id="weight" name="weight" class="form-control"
                                   value="{{ old('weight', Auth::user()->weight ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="age" class="form-label">Wiek</label>
                            <input type="number" id="age" name="age" class="form-control"
                                   value="{{ old('age', Auth::user()->age ?? '') }}">
                        </div>
                        <div id="pregnancy_fields" style="display: none;">
                            <div class="mb-3">
                                <label>Czy jesteś w ciąży lub karmisz piersią?</label><br>
                                <input type="radio" id="is_pregnant_yes" name="is_pregnant" value="1" onchange="togglePregnancyDetails()"> Jestem w ciąży
                                <input type="radio" id="is_pregnant_no" name="is_pregnant" value="0" onchange="togglePregnancyDetails()"> Nie
                            </div>
                            <div id="pregnancy_details" style="display: none;">
                                <div class="mb-3">
                                    <label for="pregnancy_week" class="form-label">Tydzień ciąży</label>
                                    <input type="number" id="pregnancy_week" name="pregnancy_week" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="pre_pregnancy_weight" class="form-label">Waga sprzed ciąży (kg)</label>
                                    <input type="number" id="pre_pregnancy_weight" name="pre_pregnancy_weight" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="delivery_date" class="form-label">Data porodu</label>
                                    <input type="date" id="delivery_date" name="delivery_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4 class="mb-3">Dane opcjonalne</h4>
                        <div class="mb-3">
                            <label for="waist_circumference" class="form-label">Obwód pasa (cm)</label>
                            <input type="number" id="waist_circumference" name="waist_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="hip_circumference" class="form-label">Obwód bioder (cm)</label>
                            <input type="number" id="hip_circumference" name="hip_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="bust_circumference" class="form-label">Obwód biustu (cm)</label>
                            <input type="number" id="bust_circumference" name="bust_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="neck_circumference" class="form-label">Obwód szyi (cm)</label>
                            <input type="number" id="neck_circumference" name="neck_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="wrist_circumference" class="form-label">Obwód nadgarstka (cm)</label>
                            <input type="number" id="wrist_circumference" name="wrist_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="bicep_circumference" class="form-label">Obwód bicepsa (cm)</label>
                            <input type="number" id="bicep_circumference" name="bicep_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="thigh_circumference" class="form-label">Obwód uda (cm)</label>
                            <input type="number" id="thigh_circumference" name="thigh_circumference" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="calf_circumference" class="form-label">Obwód łydki (cm)</label>
                            <input type="number" id="calf_circumference" name="calf_circumference" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class=" btn-success">Zapisz ankietę</button>
                </div>
            </form>

            <script>
                function togglePregnancyFields() {
                    const gender = document.querySelector('input[name="gender"]:checked')?.value;
                    document.getElementById('pregnancy_fields').style.display = (gender === 'Kobieta') ? 'block' : 'none';
                    togglePregnancyDetails();
                }

                function togglePregnancyDetails() {
                    const isPregnant = document.querySelector('input[name="is_pregnant"]:checked')?.value;
                    document.getElementById('pregnancy_details').style.display = (isPregnant === '1') ? 'block' : 'none';
                }
            </script>





            <div class="card-header">Rodzina</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Imię / Nick</th>
                        <th>Adres e-mail</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($family as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->status }}</td>
                            <td>
                                <form action="{{ route('family.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć tego członka rodziny?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background: none; color: red; cursor: pointer;">
                                        ❌
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button class=" btn-success mt-3" onclick="showInvitePopup()">Zaproś kolejną osobę</button>
            </div>


        <div id="invitePopup" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; box-shadow:0 4px 8px rgba(0,0,0,0.1); z-index:1000;">
            <h4>Zaproś nowego członka rodziny</h4>
            <form method="POST" action="{{ route('account.family.invite') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Imię</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class=" btn-success mt-2">Wyślij zaproszenie</button>
                <button type="button" class=" btn-secondary mt-2" onclick="hideInvitePopup()">Anuluj</button>
            </form>
        </div>
        <br><br>

        <script>
            function showInvitePopup() {
                document.getElementById('invitePopup').style.display = 'block';
            }

            function hideInvitePopup() {
                document.getElementById('invitePopup').style.display = 'none';
            }
        </script>


            <div class="card-header">Alergeny i Nietolerancje Pokarmowe</div>
            <div class="card-body">
                <div class="allergy-toggle">
                    <span>Alergeny i nietolerancje pokarmowe</span>
                    <label class="switch">
                        <input type="checkbox" id="allergyToggle">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="allergens-container" id="allergensContainer" style="display: none;">
                    <form method="POST" action="{{ route('allergens.save') }}">
                        @csrf
                        <div class="category" onclick="toggleSubcategory(this)">
                            <span>Mleko</span>
                            <span class="toggle-icon">▶</span>
                            <div class="subcategory">
                                <div class="sub-category" onclick="toggleSubSubcategory(this, event)">
                                    <span>Mleko krowie</span>
                                    <span class="toggle-icon">▶</span>
                                    <div class="sub-subcategory">
                                        <label><input type="checkbox" name="allergens[]" value="wszystkie_rodzaje"> Wszystkie rodzaje</label><br>
                                        <label><input type="checkbox" name="allergens[]" value="mleko_surowe"> Surowe</label>
                                    </div>
                                </div>
                                <div class="sub-category" onclick="toggleSubSubcategory(this, event)">
                                    <span>Mleko kozie</span>
                                    <span class="toggle-icon">▶</span>
                                    <div class="sub-subcategory">
                                        <label><input type="checkbox" name="allergens[]" value="kozie_surowe"> Surowe</label><br>
                                        <label><input type="checkbox" name="allergens[]" value="kozie_przetworzone"> Przetworzone</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="category" onclick="toggleSubcategory(this)">
                            <span>Orzechy</span>
                            <span class="toggle-icon">▶</span>
                            <div class="subcategory">
                                <div class="sub-category" onclick="toggleSubSubcategory(this, event)">
                                    <span>Orzechy włoskie</span>
                                    <span class="toggle-icon">▶</span>
                                    <div class="sub-subcategory">
                                        <label><input type="checkbox" name="allergens[]" value="włoskie_surowe"> Surowe</label><br>
                                        <label><input type="checkbox" name="allergens[]" value="włoskie_prażone"> Prażone</label>
                                    </div>
                                </div>
                                <div class="sub-category" onclick="toggleSubSubcategory(this, event)">
                                    <span>Orzechy laskowe</span>
                                    <span class="toggle-icon">▶</span>
                                    <div class="sub-subcategory">
                                        <label><input type="checkbox" name="allergens[]" value="laskowe_surowe"> Surowe</label><br>
                                        <label><input type="checkbox" name="allergens[]" value="laskowe_mielone"> Mielone</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="category" onclick="toggleSubcategory(this)">
                            <span>Owoce</span>
                            <span class="toggle-icon">▶</span>
                            <div class="subcategory">
                                <div class="sub-category" onclick="toggleSubSubcategory(this, event)">
                                    <span>Jabłka</span>
                                    <span class="toggle-icon">▶</span>
                                    <div class="sub-subcategory">
                                        <label><input type="checkbox" name="allergens[]" value="jabłka_surowe"> Surowe</label><br>
                                        <label><input type="checkbox" name="allergens[]" value="jabłka_prażone"> Prażone</label>
                                    </div>
                                </div>
                                <div class="sub-category" onclick="toggleSubSubcategory(this, event)">
                                    <span>Truskawki</span>
                                    <span class="toggle-icon">▶</span>
                                    <div class="sub-subcategory">
                                        <label><input type="checkbox" name="allergens[]" value="truskawki_surowe"> Surowe</label><br>
                                        <label><input type="checkbox" name="allergens[]" value="truskawki_mrożone"> Mrożone</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class=" btn-success mt-3">Zapisz</button>
                    </form>
                </div>
            </div>
        <br><br>

        <script>

            function toggleSubcategory(element) {
                const subcategory = element.querySelector('.subcategory');
                const icon = element.querySelector('.toggle-icon');
                if (subcategory) {
                    const isVisible = subcategory.style.display === 'block';
                    subcategory.style.display = isVisible ? 'none' : 'block';
                    icon.textContent = isVisible ? '▶' : '▼';


                    const categoryName = element.querySelector('span').textContent.trim();
                    localStorage.setItem(`subcategory_${categoryName}`, isVisible ? 'hidden' : 'visible');
                }
            }


            function toggleSubSubcategory(element, event) {
                event.stopPropagation();
                const subSubcategory = element.querySelector('.sub-subcategory');
                const icon = element.querySelector('.toggle-icon');
                if (subSubcategory) {
                    const isVisible = subSubcategory.style.display === 'block';
                    subSubcategory.style.display = isVisible ? 'none' : 'block';
                    icon.textContent = isVisible ? '▶' : '▼';

                    const subCategoryName = element.querySelector('span').textContent.trim();
                    localStorage.setItem(`subsubcategory_${subCategoryName}`, isVisible ? 'hidden' : 'visible');
                }
            }

            function preventPropagation(event) {
                event.stopPropagation();
            }

            function initializeCategories() {
                Object.keys(localStorage).forEach(key => {
                    if (key.startsWith('subcategory_') || key.startsWith('subsubcategory_')) {
                        localStorage.removeItem(key);
                    }
                });

                const categories = document.querySelectorAll('.category');
                categories.forEach(category => {
                    const subcategory = category.querySelector('.subcategory');
                    const icon = category.querySelector('.toggle-icon');

                    if (subcategory) {
                        subcategory.style.display = 'none';
                        icon.textContent = '▶';
                    }
                });

                const subcategories = document.querySelectorAll('.sub-category');
                subcategories.forEach(subCategory => {
                    const subSubcategory = subCategory.querySelector('.sub-subcategory');
                    const icon = subCategory.querySelector('.toggle-icon');

                    if (subSubcategory) {
                        subSubcategory.style.display = 'none';
                        icon.textContent = '▶';
                    }
                });
            }

            document.getElementById('allergyToggle').addEventListener('change', function () {
                const container = document.getElementById('allergensContainer');
                container.style.display = this.checked ? 'block' : 'none';
            });

            document.addEventListener('DOMContentLoaded', () => {
                initializeCategories();

                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('click', preventPropagation);
                });
            });
        </script>


            <div class="card-header">Aktywność fizyczna</div>
            <div class="card-body">
                <form method="POST" action="{{ route('physicalActivity.save') }}">
                    @csrf


                    <label>
                        <input type="radio" name="activity_level" value="sitting"
                            {{ old('activity_level', Auth::user()->activity_level) == 'sitting' ? 'checked' : '' }}> Tryb siedzący (mało ruchu)
                    </label><br>

                    <label>
                        <input type="radio" name="activity_level" value="low"
                            {{ old('activity_level', Auth::user()->activity_level) == 'low' ? 'checked' : '' }}> Niska aktywność (praca biurowa)
                    </label><br>

                    <label>
                        <input type="radio" name="activity_level" value="light"
                            {{ old('activity_level', Auth::user()->activity_level) == 'light' ? 'checked' : '' }}> Lekka aktywność (prace w ogrodzie)
                    </label><br>

                    <label>
                        <input type="radio" name="activity_level" value="moderate"
                            {{ old('activity_level', Auth::user()->activity_level) == 'moderate' ? 'checked' : '' }}> Średnia aktywność (prace budowlane)
                    </label><br>

                    <label>
                        <input type="radio" name="activity_level" value="high"
                            {{ old('activity_level', Auth::user()->activity_level) == 'high' ? 'checked' : '' }}> Wysoka aktywność (intensywne ćwiczenia)
                    </label><br>

                    <label>
                        <input type="radio" name="activity_level" value="very_high"
                            {{ old('activity_level', Auth::user()->activity_level) == 'very_high' ? 'checked' : '' }}> Bardzo wysoka aktywność (ciężkie prace budowlane)
                    </label><br>

                    <button type="submit" class=" btn-success mt-3">Zapisz</button>
                </form>

            </div>



            <div class="card-header">Ustawienia serwisu</div>
            <div class="card-body syf">
                <form method="POST" action="{{ route('settings.save') }}">
                    @csrf
                    <input type="checkbox" name="settings[]" value="reklamy"
                        {{ Auth::user()->disable_ads ? 'checked' : '' }}>
                    Wyłącz reklamy w serwisie <br>
                    <span style="margin-left: 20px; font-size: 14px; font-weight: 200; color: gray;">Tu można wyłączyć reklamy w serwisie</span>
                    <br>

                    <input type="checkbox" name="settings[]" value="maile"
                        {{ Auth::user()->disable_emails ? 'checked' : '' }}>
                    Wyłącz powiadomienia mailowe wysyłane z serwisu <br>
                    <span style="margin-left: 20px; font-size: 14px; font-weight: 200; color: gray;">Tu można wyłączyć maile wysyłane z serwisu</span>
                    <br>
                    <br>

                    <button type="submit" class=" btn-success">Zapisz ustawienia</button>
                </form>
            </div>


            <div class="card-header">Szablon kolorystyczny</div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.saveTheme') }}">
                    @csrf
                    <label>
                        <input type="radio" name="theme" value="default"
                            {{ Auth::user()->theme === 'default' ? 'checked' : '' }}>
                        <img src="/images/theme_default.png" alt="Domyślny szablon">
                        Domyślny szablon
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="theme" value="themeA"
                            {{ Auth::user()->theme === 'themeA' ? 'checked' : '' }}>
                        <img src="/images/theme_a.png" alt="Szablon A">
                        Szablon A
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="theme" value="themeB"
                            {{ Auth::user()->theme === 'themeB' ? 'checked' : '' }}>
                        <img src="/images/theme_b.png" alt="Szablon B">
                        Szablon B
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="theme" value="themeC"
                            {{ Auth::user()->theme === 'themeC' ? 'checked' : '' }}>
                        <img src="/images/theme_c.png" alt="Szablon C">
                        Szablon C
                    </label>
                    <br>
                    <button type="submit" class=" btn-success">Zapisz szablon</button>
                </form>
            </div>







    </div>
@endsection
