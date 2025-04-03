import { TestBed } from '@angular/core/testing';

import { ManageBoxesService } from './manage-boxes.service';

describe('ManageBoxesService', () => {
  let service: ManageBoxesService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ManageBoxesService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
