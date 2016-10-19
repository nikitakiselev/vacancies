@extends('app')

@section('content')
    <div class="search-wrapper">
        <div class="row">
            <div class="col-md-8">
                <input
                        type="text"
                        name="search"
                        placeholder="Type any keyword..."
                        class="form-control input-lg"
                        v-model="query"
                />
            </div>

            <div class="col-md-4">
                @include('partials.areas-select')
            </div>
        </div>
    </div>

    <div id="search-results" class="search-results">
        <div class="search-results-meta" v-show="results.total > 0">
            Founded @{{ results.total }} result(s).

            <span v-show="results.nbHits > results.hitsPerPage">
                Showing @{{ results.current_page + 1 }} page of @{{ results.last_page }}.
            </span>
        </div>

        <div class="alert alert-info" v-show="results.total == 0">There are no results for your request.</div>

        <ul>
            <li v-for="vacancy in results.data" class="vacancy-item">
                <a :href="vacancy.url" target="_blank">
                    <h4 v-html="vacancy.title"></h4>
                </a>

                <div class="vacancy-meta">
                    <span class="vacancy-meta-item vacancy-company"
                          v-html="vacancy.company"></span>

                    <span class="vacancy-meta-item vacancy-employment_mode">
                        Employment mode: @{{ vacancy.employment_mode }}
                    </span>

                    <span class="vacancy-meta-item vacancy-experience">
                        Experience: @{{ vacancy.experience }}
                    </span>
                </div>

                <div class="description" v-html="vacancy.description"></div>
            </li>
        </ul>

        <nav v-show="results.nbPages > 1" class="pager-wrapper">
            <ul class="pager">
                <li v-show="results.page - 1 >= 1"><a href="#" @click.prevent="prevPage">Previous</a></li>
                <li v-show="results.page + 1 < results.last_page"><a href="#" @click.prevent="nextPage">Next</a></li>
            </ul>
        </nav>
    </div>
@endsection