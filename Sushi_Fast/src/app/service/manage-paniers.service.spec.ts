import { TestBed } from '@angular/core/testing';

import { ManagePaniersService } from './manage-paniers.service';

describe('ManagePaniersService', () => {
  let service: ManagePaniersService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ManagePaniersService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
