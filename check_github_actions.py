import json
try:
    import urllib.request as urllib2
except ImportError:
    import urllib2

url = 'https://api.github.com/repos/kasandhu16/cv_app_26/actions/runs?branch=main&per_page=5'
try:
    with urllib2.urlopen(url) as res:
        data = json.load(res)
    print(json.dumps(data.get('workflow_runs', [])[:5], indent=2))
except Exception as e:
    print('ERROR', e)
