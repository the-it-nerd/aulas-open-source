// app/code/YourVendor/YourModule/view/frontend/web/js/view/payment/custom-message.js
define([
    'mage/url'
], function (urlBuilder) {
    'use strict';

    const model = {

        updateCache: function(data) {
            window.localStorage.setItem('snappoints-rules', JSON.stringify(data));
            window.localStorage.setItem('snappoints-rules-version', data.version);
            window.localStorage.setItem('snappoints-rules-init', Date.now())
            return this;
        },

        getCacheVersion: function() {
            return window.localStorage.getItem('snappoints-rules-version');
        },

        getCacheData: function() {
            let data = window.localStorage.getItem('snappoints-rules');
            if(data) {
                return JSON.parse(data);
            }
            return data;
        },

        needCacheRefresh: function() {
            const cacheInitTimestampString = window.localStorage.getItem('snappoints-rules-init');

            if (!cacheInitTimestampString) {
                return true;
            }

            const cacheInitTimestamp = parseInt(cacheInitTimestampString, 10);
            if (isNaN(cacheInitTimestamp)) {
                console.warn('Invalid cache initialization timestamp found.');
                return true;
            }

            const currentTime = Date.now();
            const oneHourInMilliseconds = 60 * 60 * 1000;

            if ((currentTime - cacheInitTimestamp) > oneHourInMilliseconds) {
                return true;
            }

            return false;
        },

        getRatioRuleByProductId: async function(productId) {
            let selectedRule = null;
            let selectedRuleRatio = null;
            let rules = await this.loadRules();

            if(rules.rules.length > 0) {
                rules.rules.forEach((rule) => {
                    if(rule.includes.includes(""+productId)) {
                        if(selectedRuleRatio === null || selectedRuleRatio > rule.giveBackRatio) {
                            selectedRule = rule;
                            selectedRuleRatio = rule.giveBackRatio;
                        }
                    }
                });
            }

            console.log(selectedRuleRatio, window.snapPointsPrograms.maxGiveBackRatio);

            return selectedRuleRatio;

        },

        loadRules: async function() {
            try {
                let cache = this.getCacheData();
                if(cache && !this.needCacheRefresh()) {
                    return cache;
                }

                let url = urlBuilder.build('/rest/V1/snappoints-loyalty/rules');

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    let errorBody = 'Could not read error details.';
                    try {
                        errorBody = await response.text();
                    } catch (readError) {
                        console.warn("Could not read response body for error.", readError);
                    }
                    throw new Error(`HTTP error! status: ${response.status}, Body: ${errorBody}`);
                }
                const data = await response.json();

                let responseObj = {
                    version: [],
                    rules: []
                };

                data.forEach((rule) => {
                    responseObj.version.push(rule.version);
                    responseObj.rules.push({rule_id: rule.id, includes: rule.include.map((a) => a.id), excludes: rule.exclude.map((a) => a.id), version: rule.version, giveBackRatio: rule.giveBackRatio });
                });

                responseObj.version = btoa(responseObj.version.join('_'));

                this.updateCache(responseObj);

                return responseObj;

            } catch (error) {
                console.error('Fetch request failed (async/await):', error);
                // Handle server-side failure (show message to user ?)
            }
            console.log('asdasdas');
            // window.localStorage.setItem('snappoints-rules-init', Date.now());
        }
    }


    model.loadRules();

    return model;
});
