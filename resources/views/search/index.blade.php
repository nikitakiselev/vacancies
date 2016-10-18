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
        <div class="search-results-meta">
            Founded @{{ results.nbHits }} result(s) in @{{ results.processingTimeMS }} milliseconds(s).

            <span v-show="results.nbHits > results.hitsPerPage">Showing @{{ results.page + 1 }} page of @{{ results.nbPages }}.</span>
        </div>

        <div class="alert alert-info" v-show="results.nbHits == 0">There are no results for your request.</div>

        <ul>
            <li v-for="vacancy in results.hits" class="vacancy-item">
                <a :href="vacancy.url" target="_blank">
                    <h4 v-html="vacancy._highlightResult.title.value"></h4>
                </a>

                <div class="vacancy-meta">
                    <span class="vacancy-meta-item vacancy-company"
                          v-html="vacancy._highlightResult.company.value"></span>

                    <span class="vacancy-meta-item vacancy-employment_mode">
                        Employment mode: @{{ vacancy.employment_mode }}
                    </span>

                    <span class="vacancy-meta-item vacancy-experience">
                        Experience: @{{ vacancy.experience }}
                    </span>
                </div>

                <div class="description" v-html="vacancy._highlightResult.description.value"></div>
            </li>
        </ul>

        <nav v-show="results.nbPages > 0" class="pager-wrapper">
            <ul class="pager">
                <li v-show="results.page - 1 >= 0"><a href="#" @click.prevent="prevPage">Previous</a></li>
                <li v-show="results.page + 1 < results.nbPages"><a href="#" @click.prevent="nextPage">Next</a></li>
            </ul>
        </nav>
    </div>
@endsection