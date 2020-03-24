/**
 *  Copyright (c) Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 *  @flow
 */

import type {Hover} from 'vscode-languageserver-types';

import {expect} from 'chai';
import {beforeEach, describe, it} from 'mocha';
import fs from 'fs';
import {buildSchema} from 'graphql';
import {Position} from 'graphql-language-service-utils';
import path from 'path';

import {getHoverInformation} from '../getHoverInformation';

describe('getHoverInformation', () => {
  let schema;
  beforeEach(async () => {
    const schemaIDL = fs.readFileSync(
      path.join(__dirname, '__schema__/HoverTestSchema.graphql'),
      'utf8',
    );
    schema = buildSchema(schemaIDL);
  });

  function testHover(query: string, point: Position): Hover.contents {
    return getHoverInformation(schema, query, point);
  }

  it('provides leaf field information', () => {
    const actual = testHover(
      'query { thing { testField } }',
      new Position(0, 20),
    );
    expect(actual).to.deep.equal(
      'TestType.testField: String\n\n This is field documentation for TestType.testField',
    );
  });

  it('provides aliased field information', () => {
    const actual = testHover(
      'query { thing { other: testField } }',
      new Position(0, 25),
    );
    expect(actual).to.deep.equal(
      'TestType.testField: String\n\n This is field documentation for TestType.testField',
    );
  });

  it('provides intermediate field information', () => {
    const actual = testHover(
      'query { thing { testField } }',
      new Position(0, 10),
    );
    expect(actual).to.deep.equal(
      'Query.thing: TestType\n\n This is field documentation for Query.thing',
    );
  });

  it('provides list field information', () => {
    const actual = testHover(
      'query { listOfThing { testField } }',
      new Position(0, 10),
    );
    expect(actual).to.deep.equal('Query.listOfThing: [TestType!]');
  });

  it('provides deprecated field information', () => {
    const actual = testHover(
      'query { thing { testDeprecatedField } }',
      new Position(0, 20),
    );
    expect(actual).to.deep.equal(
      'TestType.testDeprecatedField: Float\n\nDeprecated: deprecation reason',
    );
  });

  it('provides enum field information', () => {
    const actual = testHover(
      'query { thing { testEnumField } }',
      new Position(0, 20),
    );
    expect(actual).to.deep.equal('TestType.testEnumField: Color');
  });

  it('provides scalar field information', () => {
    const actual = testHover('query { cluck }', new Position(0, 10));
    expect(actual).to.deep.equal('Query.cluck: Chicken');
  });

  it('provides parameter type information', () => {
    const actual = testHover(
      'query { parameterizedField(id: "foo") { testField } }',
      new Position(0, 28),
    );
    expect(actual).to.deep.equal('Query.parameterizedField(id: String!)');
  });

  it('provides directive information', () => {
    const actual = testHover(
      'query { thing { testField @skip(if:true) } }',
      new Position(0, 30),
    );
    expect(actual).to.deep.equal(
      '@skip\n\nDirects the executor to skip this field or fragment when the `if` argument is true.',
    );
  });

  it('provides union information', () => {
    const actual = testHover('query { unionField }', new Position(0, 12));
    expect(actual).to.deep.equal('Query.unionField: UnionType');
  });
});
